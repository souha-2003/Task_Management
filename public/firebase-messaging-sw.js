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
    
    const title = payload.notification?.title || 'Notification';
    const body = payload.notification?.body || '';
    
    const notificationOptions = {
        body: body,
        icon: '/favicon.ico',
        data: payload.data
    };

    self.registration.showNotification(title, notificationOptions);
});
