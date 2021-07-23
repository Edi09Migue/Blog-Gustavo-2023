export default  {
    tileProviders : [
        {
            name: 'OpenStreetMap',
            visible: true,
            attribution:
            '&copy; <a target="_blank" href="http://osm.org/copyright">OpenStreetMap</a> contributors',
            url: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
        },
        {
            name: 'OpenTopoMap',
            visible: false,
            url: 'https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png',
            attribution:
            'Map data: &copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>, <a href="http://viewfinderpanoramas.org">SRTM</a> | Map style: &copy; <a href="https://opentopomap.org">OpenTopoMap</a> (<a href="https://creativecommons.org/licenses/by-sa/3.0/">CC-BY-SA</a>)',
        },
    ],
    rrnnLayers : [
        {
        name: 'Parroquias',
        visible: true,
        format: 'image/png; mode=8bit',
        transparent: true,
        opacity: 0.6,
        layers: 'parroquias',
        version: '1.1.1',
        bbox :'-78.857685631137,-1.4218850961551,-78.202410690726,-1.1609180413979',
        crs: L.CRS.EPSG4326,
        attribution:'&copy; <a target="_blank" href="http://rrnn.tungurahua.gob.ec">GeoPortal HGPT</a>',
        url: 'https://mapas.tungurahua.gob.ec/base?_signature=35%3AtQ4w1U9PYXX2oUR-XmrygmZzxcU&',
      },
        {
        name: 'Cantones',
        visible: false,
        format: 'image/png; mode=8bit',
        transparent: true,
        opacity: 0.6,
        layers: 'tungurahuacantones',
        version: '1.1.1',
        bbox :'-78.857685631137,-1.4218850961551,-78.202410690726,-1.1609180413979',
        crs: L.CRS.EPSG4326,
        attribution:'&copy; <a target="_blank" href="http://rrnn.tungurahua.gob.ec">GeoPortal HGPT</a>',
        url: 'https://mapas.tungurahua.gob.ec/base?_signature=35%3AtQ4w1U9PYXX2oUR-XmrygmZzxcU&',
      }
    ]
}