$.fn.extend({
    adminNotifications() {
        const adminNotificationWrapper = $(this);
        const frequency = adminNotificationWrapper.attr('data-frequency') * 1000;
        const limit = adminNotificationWrapper.attr('data-limit');
        const notificationsPath = adminNotificationWrapper.attr('data-url');
        const template = adminNotificationWrapper.attr('data-template');
        const emptyTemplate = adminNotificationWrapper.attr('data-empty-template');
        const loaderTemplate = adminNotificationWrapper.attr('data-loader-template');
        const notificationsList = adminNotificationWrapper.find('#websnacks-admin-notifications');
        const markAsReadButtonClass = '.mark-as-read';
        const markAllAsReadButtonClass = '.websnacks-mark-all-as-read';
        let notifications = [];
        let lastRefresh = null;
        let locked = false;
        let noMore = false;
        let unread = 0;

        const reloadCounters = function reloadCounters() {
            const counter = adminNotificationWrapper.find('#websnacks-admin-notifications-counter');
            adminNotificationWrapper.find('[data-counter]').html(unread);
            if (unread > 0) {
                counter.removeClass('hidden');
            } else {
                counter.addClass('hidden');
            }
        };

        const markAsReadClick = function markAsReadClick(event) {
            event.preventDefault();
            event.stopPropagation();
            const button = $(this);
            const adminNotification = button.parents('.admin-notification');
            const notificationId = button.attr('data-notification-id');
            const url = button.attr('href');

            $.ajax({
                type: 'POST',
                url: url,
                accept: 'application/json',
                data: {
                    'notification_id': notificationId
                },
                success: function (response) {
                    unread = response.data.unread;
                    if ('all' !== notificationId) {
                        adminNotification.removeClass('unseen');
                        for (let i = 0; i < notifications.length; i++) {
                            if (notifications[i].id === parseInt(notificationId)) {
                                notifications[i].unread = false;
                            }
                        }
                    }
                    reloadCounters();
                }
            });
        };

        const refreshList = function refreshList() {
            notificationsList.html('');
            if (notifications.length > 0) {
                $.each(notifications, function (i, notification) {
                    let notificationElement = $(template
                        .replace('||message||', notification.message)
                        .replace('||id||', notification.id)
                        .replace('||created||', notification.created));
                    if (typeof notification.click_action !== 'undefined') {
                        notificationElement.on('click', function (event) {
                            event.preventDefault();
                            window.location = notification.click_action;
                        });
                    } else {
                        notificationElement.on('click', function (event) {
                            event.stopPropagation();
                        });
                    }
                    if (true === notification.unread) {
                        notificationElement.addClass('unseen');
                    }
                    notificationsList.append(notificationElement);
                });
                notificationsList.find(markAsReadButtonClass).on('click', markAsReadClick);
            } else {
                notificationsList.append(emptyTemplate);
            }
            reloadCounters();
            unlock();
        };

        const lockIfNoMore = function lockIfNoMore(limit, loadedNumber) {
            if (0 === loadedNumber) {
                removeLoader();
                noMore = true;
            } else if (limit > loadedNumber) {
                noMore = true;
            }
        };

        const pushIntoList = function pushIntoList(newNotifications, isOffset) {
            if (isOffset) {
                $.each(newNotifications, function (i, notification) {
                    notifications.push(notification);
                });
            } else {
                $.each(newNotifications.reverse(), function (i, notification) {
                    notifications.unshift(notification);
                });
            }
            let waitFor = 0;
            if (isOffset) {
                waitFor = 1000;
            }
            sleep(waitFor).then(() => {
                refreshList();
                unlock();
            });
        };

        const getNotifications = function getNotifications(offset) {
            let isOffset = typeof offset !== 'undefined';
            if (true === locked || (isOffset && noMore)) {
                return;
            }
            lock();
            let path = notificationsPath + '?limit=' + limit + '&';
            if (isOffset) {
                addLoader();
                path = path + 'offset=' + offset;
            } else {
                path = path + 'last_refresh=' + lastRefresh
            }
            $.ajax({
                type: 'GET',
                url: path,
                accept: 'application/json',
                error: function() {
                    unlock();
                },
                success: function (response) {
                    unread = response.data.unread;
                    lastRefresh = response.data.last_refresh;
                    let notificationCount = response.data.notifications.length;
                    if (isOffset) {
                        lockIfNoMore(limit, notificationCount);
                    }
                    unlock();
                    pushIntoList(response.data.notifications, isOffset);
                }
            });
        };

        const lock = function lock() {
            locked = true;
        };

        const unlock = function unlock() {
            locked = false;
        };

        const removeLoader = function () {
            notificationsList.find('.loader-wrapper').remove();
        };

        const addLoader = function addLoader() {
            notificationsList.append(loaderTemplate);
            notificationsList.animate({scrollTop:notificationsList.prop('scrollHeight')}, 'slow');
        };

        const sleep = function sleep(ms) {
            return new Promise(resolve => setTimeout(resolve, ms));
        };

        notificationsList.on('scroll', function() {
            if (notificationsList.scrollTop() + notificationsList.height() >= notificationsList.prop('scrollHeight')) {
                getNotifications(notifications.length);
            }
        });

        adminNotificationWrapper.find(markAllAsReadButtonClass).on('click', markAsReadClick);

        getNotifications();

        window.setInterval(function () {
            getNotifications()
        }, frequency);
    }
});

if ($('#websnacks-admin-notifications-wrapper').length) {
  $('#websnacks-admin-notifications-wrapper').adminNotifications();
}
