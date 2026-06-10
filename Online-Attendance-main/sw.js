const CACHE_NAME = 'smartattend-cache-v25';
const urlsToCache = [
  '/',
  '/index.html',
  '/login/login.html',
  '/login/student/index.html',
  '/login/student/login.html',
  '/login/teacher/index.html',
  '/about.html',
  '/privacy.html',
  '/terms.html',
  '/css/style.css',
  '/css/login.css?v=2',
  '/js/app.js',
  '/img/padded_new_logo.svg',
  '/img/smartattend_logo.svg',
  '/img/logo.png',
  '/manifest.json'
];

self.addEventListener('install', function(event) {
  self.skipWaiting();
  event.waitUntil(
    caches.open(CACHE_NAME).then(function(cache) {
      return Promise.all(
        urlsToCache.map(function(url) {
          return cache.add(url).catch(function(error) {
            console.error('Failed to cache:', url, error);
          });
        })
      );
    })
  );
});

self.addEventListener('activate', event => {
  event.waitUntil(
    caches.keys().then(cacheNames => {
      return Promise.all(
        cacheNames.map(cacheName => {
          if (cacheName !== CACHE_NAME) {
            return caches.delete(cacheName);
          }
        })
      );
    })
  );
});

self.addEventListener('fetch', function(event) {
  event.respondWith(
    caches.match(event.request).then(function(response) {
      return response || fetch(event.request);
    }).catch(function() {
      // Fallback if offline and not in cache
      return new Response('You are offline and this page is not cached.', {
        status: 503,
        statusText: 'Service Unavailable',
        headers: new Headers({ 'Content-Type': 'text/plain' })
      });
    })
  );
});
