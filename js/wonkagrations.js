(function(i, s, o, g, r, a, m){
i['__GetResponseAnalyticsObject'] = r;i[r] = i[r] || function() {(i[r].q = i[r].q || []).push(arguments); };
a = s.createElement(o);m = s.getElementsByTagName(o)[0];a.async = 1;a.src = g;m.parentNode.insertBefore(a, m);
})(window, document, 'script', 'https://ga.getresponse.com/script/ga.js?v=2&grid=sBDcIX0NffHoIBw%3D%3D', 'GrTracking');

// Creates a default GetResponse Tracker with automatic cookie domain configuration.
GrTracking('setDomain', 'auto');

// Sends a pageview hit from the tracker just created.
// allways load current window.location.href - usefull for single page applications
GrTracking('push');