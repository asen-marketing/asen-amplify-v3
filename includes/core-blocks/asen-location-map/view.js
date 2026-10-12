// Leaflet map per block; coordinates are geocoded server-side and passed as data attributes.
document.querySelectorAll('.asen-location-map .map[data-lat]').forEach((el) => {
  if (typeof L === 'undefined') return;
  const lat = parseFloat(el.dataset.lat);
  const lon = parseFloat(el.dataset.lon);
  const escape = (s) => s.replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));

  const map = L.map(el).setView([lat, lon], 16);
  L.tileLayer(el.dataset.tiles, {
    maxZoom: parseInt(el.dataset.maxZoom, 10) || 19,
    attribution: el.dataset.attribution || '',
  }).addTo(map);

  const markerOptions = {};
  if (el.dataset.marker) {
    const w = parseInt(el.dataset.markerWidth, 10) || 40;
    const h = parseInt(el.dataset.markerHeight, 10) || 40;
    markerOptions.icon = L.icon({ iconUrl: el.dataset.marker, iconSize: [w, h], iconAnchor: [w / 2, h], popupAnchor: [0, -h] });
  }

  let popup = '';
  if (el.dataset.name) popup += '<span class="business-name">' + escape(el.dataset.name) + '</span><br>';
  popup += '<span class="address">' + escape(el.dataset.address) + '</span>';
  if (el.dataset.directions) popup += '<br><a class="directions-link" href="' + escape(el.dataset.directions) + '" target="_blank" rel="noopener">Get Directions</a>';

  L.marker([lat, lon], markerOptions).addTo(map).bindPopup(popup).openPopup();
});
