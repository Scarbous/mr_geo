define([
    'jquery',
    '//maps.googleapis.com/maps/api/js?v=3&libraries=places,geometry'
], function ($) {
    'use strict';

    var GoogleMaps = {
        geocoder: new google.maps.Geocoder(),
        option: {
            initZoom: 4,
            foundZoom: 12,
            defaultGeo: new google.maps.LatLng(51.1656910, 10.4515260)
        }
    };

    GoogleMaps.setGeo = function (location) {
        this.marker.setPosition(location);
        this.$input.val(location.lat() + '|' + location.lng());
        this.geoLat.val(location.lat());
        this.geoLng.val(location.lng());
    };

    GoogleMaps.getGeo = function () {
        var geo = this.$input.val();
        console.log(geo);
        if (geo.trim()) {
            geo = geo.split('|');
            return new google.maps.LatLng(geo[0], geo[1]);
        }
        return this.option.defaultGeo;
    };

    GoogleMaps.getCenter = function () {
        var geo = this.getGeo();
        return geo ? geo : this.option.defaultGeo
    };

    GoogleMaps.initialize = function (selector) {
        var root = this;
        root.selector = selector;
        root.$input = $('input[data-geo-result]', selector);
        root.$map = $('.mr-geo-map', selector);
        root.$search = $('input[data-geo-search]', selector);
        root.geoLat = $('input[data-geo-lat]', selector);
        root.geoLng = $('input[data-geo-lng]', selector);

        var initialGeo = root.getGeo();

        root.geoLat.val(initialGeo.lat());
        root.geoLng.val(initialGeo.lng());

        root.autocomplete = new google.maps.places.Autocomplete(root.$search[0]);
        google.maps.event.addListener(root.autocomplete, 'place_changed', function () {
            var place = root.autocomplete.getPlace();
            root.setGeo(place.geometry.location);
            root.map.setCenter(location);
            root.map.setZoom(root.option.foundZoom);
        });

        var mapOptions = {
            zoom: root.option.initZoom,
            scrollwheel: true,
            streetViewControl: false,
            mapTypeControl: true
        };
        if (initialGeo === this.option.defaultGeo) {
            mapOptions.center = this.option.defaultGeo;
        } else {
            mapOptions.center = initialGeo;
            mapOptions.zoom = root.option.foundZoom;
        }
        root.map = new google.maps.Map(root.$map[0], mapOptions);

        var markerOptions = {
            map: root.map,
            draggable: true
        };
        if (initialGeo === this.option.defaultGeo) {
            markerOptions.position = this.option.defaultGeo;
        } else {
            markerOptions.position = initialGeo;
        }
        root.marker = new google.maps.Marker(markerOptions);

        root.marker.addListener('dragend', function () {
            GoogleMaps.setGeo(root.marker.getPosition());
        });

        root.map.addListener('click', function (e) {
            var clickedLocation = e.latLng;
            GoogleMaps.setGeo(clickedLocation);
        });

    };
    return GoogleMaps;

});