// Firebase SDKs Compatibility
importScripts('https://www.gstatic.com/firebasejs/10.8.0/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/10.8.0/firebase-messaging-compat.js');

const firebaseConfig = {
    apiKey: "AIzaSyDmKeP3bqBfDYet_usW46t89IxoQds-DdA",
    authDomain: "task-management-c3bff.firebaseapp.com",
    projectId: "task-management-c3bff",
    storageBucket: "task-management-c3bff.firebasestorage.app",
    messagingSenderId: "731879977881",
    appId: "1:731879977881:web:53e7b1f5aae69734539908",
    measurementId: "G-HXDX8LDZ61"
};

firebase.initializeApp(firebaseConfig);
const messaging = firebase.messaging();

// التعامل مع الإشعارات عندما يكون الموقع مغلقاً أو في الخلفية
messaging.onBackgroundMessage((payload) => {
    console.log('تم استقبال إشعار في الخلفية:', payload);
    
    const title = payload.notification?.title || 'إشعار جديد';
    const body = payload.notification?.body || '';
    const taskId = payload.data?.task_id;
    
    const notificationOptions = {
        body: body,
        icon: '/favicon.ico',
        data: {
            url: taskId ? `/tasks/${taskId}` : '/notifications/history'
        }
    };

    self.registration.showNotification(title, notificationOptions);
});

// التعامل مع النقر على إشعار نظام الويندوز
self.addEventListener('notificationclick', function(event) {
    event.notification.close();

    const targetUrl = event.notification.data?.url || '/notifications/history';

    event.waitUntil(
        clients.matchAll({ type: 'window', includeUncontrolled: true }).then(function(clientList) {
            for (let i = 0; i < clientList.length; i++) {
                let client = clientList[i];
                if (client.url.includes(targetUrl) && 'focus' in client) {
                    return client.focus();
                }
            }
            if (clients.openWindow) {
                return clients.openWindow(targetUrl);
            }
        })
    );
});
