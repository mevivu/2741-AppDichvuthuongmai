<script>
    $(document).ready(function () {
        reloadData();
        const firebaseConfig = {
            apiKey: "{{ config('firebase.api_key') }}",
            authDomain: "{{ config('firebase.auth_domain') }}",
            projectId: "{{ config('firebase.project_id') }}",
            storageBucket: "{{ config('firebase.storage_bucket') }}",
            messagingSenderId: "{{ config('firebase.messaging_sender_id') }}",
            appId: "{{ config('firebase.app_id') }}",
            measurementId: "{{ config('firebase.measurement_id') }}"
        };
        console.log(firebaseConfig)
        if (!firebase.apps.length) {
            firebase.initializeApp(firebaseConfig);
        }
        const messaging = firebase.messaging();
        navigator.serviceWorker.addEventListener('message', function(event) {
            console.log("Message from Service Worker:", event.data);
            // if(event.data && event.data.message === "Notification received") {
            // }
             reloadData()
        });

        // function clearCookies() {
        //     console.log('Current cookies:', document.cookie);
        //     var cookies = document.cookie.split(";");
        //
        //     if (!cookies[0]) console.log("No cookies to clear.");
        //
        //     for (var i = 0; i < cookies.length; i++) {
        //         var cookie = cookies[i];
        //         var eqPos = cookie.indexOf("=");
        //         var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie.trim();
        //         document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/";
        //     }
        //
        //     console.log("Cookies cleared.");
        // }
        //
        // clearCookies()
        // clearCaches();

        function registerServiceWorker() {
            if ("serviceWorker" in navigator) {
                console.log('Service worker is supported');

                navigator.serviceWorker.register(`${urlHome}/firebase-messaging-sw.js`)
                    .then(registration => {
                        if (registration.active) {
                            console.log('Service worker already active');
                            initMessaging(registration);
                        } else {
                            registration.addEventListener('updatefound', () => {
                                const newWorker = registration.installing;
                                newWorker.addEventListener('statechange', () => {
                                    if (newWorker.state === 'activated') {
                                        sendConfigToServiceWorker(newWorker);
                                        initMessaging(registration);
                                    }
                                });
                            });
                        }
                    })
                    .catch(err => console.error('Service worker registration failed:', err));
            }
        }

        function sendConfigToServiceWorker(worker) {
            worker.postMessage({
                type: 'SETUP',
                config: firebaseConfig,
                userId: getUserId()
            });
        }

        function initMessaging(registration) {
            console.log('Service worker registration successful:', registration);
            messaging.useServiceWorker(registration);
            requestNotificationPermission(registration);
            handleTokenRefresh(registration);
        }

        function requestNotificationPermission(registration) {
            Notification.requestPermission().then(permission => {
                if (permission === "granted") {
                    console.log("Notification permission granted.");
                    retrieveAndUpdateToken(registration);
                } else {
                    alert("Please enable notifications to get information.");
                }
            });
        }

        function retrieveAndUpdateToken(registration) {
            messaging.getToken({
                vapidKey: "{{ config('firebase.vapid_key') }}",
                serviceWorkerRegistration: registration
            })
                .then(token => {
                    if (token) {
                        console.log('Current token for client:', token);
                        $('input[name="device_token"]').val(token);
                        if (userIsLoggedIn()) {
                            updateDeviceToken(token);
                        } else {
                            console.log('User not logged in, skipping server update for device token.');
                        }
                    } else {
                        console.warn('No registration token available. Request permission to generate one.');
                    }
                })
                .catch(err => console.error('Error retrieving token:', err));
        }

        function updateDeviceToken(deviceToken) {
            const userId = getUserId();
            if (!userId) {
                console.log('No user logged in, cannot update token on server');
                return;
            }

            $.ajax({
                url: `${urlHome}/admin/notifications/update-device-token`,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token
                },
                data: {user_id: userId, device_token: deviceToken},
                success: (data) => console.log(data.message),
                error: err => {
                    console.error('Error updating token on server:', err);
                }
            });
        }

        function userIsLoggedIn() {
            return !!getUserId();
        }

        function getUserId() {
            let userId = null;
            @if(auth('admin')->check())
                userId = @json(auth('admin')->user()->id);
            @endif
                return userId;
        }

        function handleTokenRefresh(registration) {
            messaging.onTokenRefresh(() => retrieveAndUpdateToken(registration));
        }

        // function handleIncomingMessages() {
        //     messaging.onMessage(payload => {
        //         console.log("Payload received:", payload);
        //         const {title, body, icon} = payload.notification;
        //         new Notification(title, {body, icon});
        //         reloadData()
        //     });
        // }

        function renderNotifications(notifications) {
            $('#message-box .badge').text(notifications?.length);

            const $messageBox = $('#message-box .dropdown-menu');
            $messageBox.empty();

            notifications?.forEach(function (notification) {
                const timeDiff = timeSince(notification.created_at);
                const notificationElement = `
            <a href="#" class="dropdown-item d-flex justify-content-between ">
                ${notification.title}
                <div class="text-muted small mt-1">${timeDiff}</div>
            </a>
            `;
                $messageBox.append(notificationElement);
            });

            $messageBox.append('<div class="dropdown-divider"></div>');
            $messageBox.append('<a href="#" class="dropdown-item text-center">Xem tất cả</a>');
        }

        function reloadData() {
            const userId = getUserId();
            $.ajax({
                url: urlHome + '/admin/notifications/not-read?admin_id=' + userId,
                type: 'GET',
                success: function (data) {
                    console.log(data.notifications)
                    renderNotifications(data.notifications);
                },
                error: function (error) {
                    console.error('Error fetching notifications:', error);
                }
            });
        }
        $('#message-box').on('hide.bs.dropdown', function () {
            updateNotificationStatus(getUserId());
        });
        function updateNotificationStatus(userId) {
            $.ajax({
                url: urlHome + '/admin/notifications/status',
                type: 'PATCH',
                data: {
                    admin_id: userId
                },
                headers: {
                    'X-CSRF-TOKEN': token
                },
                success: function(response) {
                    console.log(response.success);
                    reloadData();
                },
                error: function(error) {
                    console.error('Error updating notification status:', error);
                }
            });
        }

        registerServiceWorker();
    });

</script>
