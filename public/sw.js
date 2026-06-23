// Service Worker para Web Push Notifications - App Curiosa

self.addEventListener('push', function (event) {
    if (!event.data) return;

    let data = {};
    try {
        data = event.data.json();
    } catch (e) {
        data = { title: 'App Curiosa', body: event.data.text() };
    }

    const title   = data.title || 'App Curiosa';
    const options = {
        body:    data.body  || 'Hay algo nuevo para ti.',
        icon:    data.icon  || '/icon-192.png',
        badge:   '/icon-192.png',
        data:    { url: data.url || '/' },
        vibrate: [200, 100, 200],
    };

    event.waitUntil(self.registration.showNotification(title, options));
});

self.addEventListener('notificationclick', function (event) {
    event.notification.close();

    const url = event.notification.data?.url || '/';

    event.waitUntil(
        clients.matchAll({ type: 'window', includeUncontrolled: true }).then(function (windowClients) {
            for (const client of windowClients) {
                if (client.url.includes(self.location.origin) && 'focus' in client) {
                    client.navigate(url);
                    return client.focus();
                }
            }
            if (clients.openWindow) {
                return clients.openWindow(url);
            }
        })
    );
});
