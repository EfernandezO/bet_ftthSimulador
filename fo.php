<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Topología FTTH Profesional</title>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jointjs/3.7.7/joint.min.css"/>
    <style>
        body, html { margin: 0; padding: 0; width: 100%; height: 100%; background-color: #f0f2f5; overflow: hidden; font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; }
        #paper-container { width: 100vw; height: 100vh; overflow: auto; cursor: grab; }
        #paper-container:active { cursor: grabbing; }
        .controls {
            position: fixed; top: 20px; left: 20px; z-index: 100;
            background: rgba(255, 255, 255, 0.95); padding: 15px; border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1); width: 280px; border: 1px solid #dcdfe6;
            pointer-events: none;
        }
        h2 { margin: 0 0 8px 0; font-size: 16px; color: #1a1a1a; }
        p { margin: 0; font-size: 11px; color: #606266; line-height: 1.4; }
        .color-dot { display: inline-block; width: 8px; height: 8px; border-radius: 50%; margin-right: 4px; }
    </style>
</head>
<body>

<div class="controls">
    <h2>Red FTTH - Nivel II</h2>
    <p><b>Transporte M1 → M2 (Bandeja 3):</b></p>
    <p><span class="color-dot" style="background:green"></span>Verde → <span style="color:blue">Azul (H9)</span></p>
    <p><span class="color-dot" style="background:brown"></span>Café → <span style="color:#e67e22">Naranja (H13)</span></p>
    <p><span class="color-dot" style="background:red"></span>Rojo → <span style="color:green">Verde (H11)</span></p>
    <p><span class="color-dot" style="background:black"></span>Negro → <span style="color:brown">Café (H15)</span></p>
</div>

<div id="paper-container">
    <div id="joint-canvas"></div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.21/lodash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.4.1/backbone-min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jointjs/3.7.7/joint.min.js"></script>

<script>
    const graph = new joint.dia.Graph();
    const paper = new joint.dia.Paper({
        el: document.getElementById('joint-canvas'),
        model: graph,
        width: 4000, height: 3000, gridSize: 5,
        drawGrid: { name: 'mesh', color: '#e0e0e0' },
        background: { color: '#f8f9fa' },
        defaultRouter: { name: 'manhattan', args: { step: 5, padding: 15 } },
        defaultConnector: { name: 'rounded' },
        interactive: { linkMove: false }
    });

    const COLORES = ['#0055ff','#ff8800','#00aa00','#8b4513','#808080','#ffffff','#ff0000','#000000','#eeee00','#800080','#ffc0cb','#00ffff'];

    // --- CUSTOM SHAPES ---

    // OLT / EDFA / ODF Base
    const Hardware = joint.shapes.standard.Rectangle.define('ftth.Hardware', {
        attrs: {
            body: { fill: '#2c3e50', stroke: '#1a252f', strokeWidth: 2, rx: 4 },
            label: { fill: '#ffffff', fontSize: 11, fontWeight: 'bold', refY: -15 }
        }
    });

    // Bandeja de Mufa
    const Bandeja = joint.shapes.standard.Rectangle.define('ftth.Bandeja', {
        attrs: {
            body: { fill: '#ffffff', stroke: '#dcdfe6', strokeWidth: 1, rx: 6 },
            label: { fill: '#909399', fontSize: 10, fontWeight: 'bold', refY: 8, refX: 10, textAnchor: 'start' }
        }
    });

    // Splitter Compacto
    const Splitter = joint.shapes.standard.Polygon.define('ftth.Splitter', {
        attrs: {
            body: { refPoints: '0,15 40,0 40,30', fill: '#f39c12', stroke: '#d35400', strokeWidth: 1.5 },
            label: { fontSize: 8, fill: '#ffffff', refX: '75%', refY: '50%', fontWeight: 'bold' }
        },
        ports: {
            groups: {
                'in': { position: 'left', attrs: { circle: { r: 3, fill: '#3498db' } } },
                'out': { position: 'right', attrs: { circle: { r: 2.5, fill: '#2ecc71' } } }
            }
        }
    });

    // CTO Compacta
    const CTO = joint.shapes.standard.Rectangle.define('ftth.CTO', {
        attrs: {
            body: { fill: '#ffffff', stroke: '#409eff', strokeWidth: 2, rx: 3 },
            label: { fill: '#303133', fontSize: 9, fontWeight: 'bold' }
        },
        ports: { groups: { 'in': { position: 'left', attrs: { circle: { r: 3, fill: '#f56c6c' } } } } }
    });

    // --- CONSTRUCCIÓN ---

    // 1. Cabecera (OLT -> EDFA -> ODF)
    const olt = new Hardware().position(50, 100).size(180, 120).attr({label:{text:'OLT - GPON CHASSIS'}, body:{fill:'#304156'}}).addTo(graph);
    const edfa = new Hardware().position(300, 100).size(80, 120).attr({label:{text:'EDFA'}, body:{fill:'#13ce66'}}).addTo(graph);
    const odf = new Hardware().position(450, 80).size(100, 200).attr({label:{text:'ODF RACK'}}).addTo(graph);

    // Puertos ODF con etiquetas
    for(let i=1; i<=12; i++) {
        odf.addPort({ id: 'in_'+i, group: 'in', position: 'left', label: { text: 'P'+i, attrs: { text: { fontSize: 8, fill: '#fff'} } } });
        odf.addPort({ id: 'out_'+i, group: 'out', position: 'right', label: { text: 'H'+i, attrs: { text: { fontSize: 8, fill: '#fff'} } } });
    }

    // Conexiones iniciales simplificadas
    for(let i=1; i<=4; i++) {
        olt.addPort({ id: 'p_'+i, group: 'out', position: 'right' });
        edfa.addPort({ id: 'in_'+i, group: 'in', position: 'left' });
        edfa.addPort({ id: 'out_'+i, group: 'out', position: 'right' });
        
        new joint.shapes.standard.Link().source(olt, {port:'p_'+i}).target(edfa, {port:'in_'+i}).attr({line:{stroke:'#909399', strokeWidth:1}}).addTo(graph);
        
        // Splitter 1:2 interno hacia ODF
        const sp12 = new Splitter().position(400, 75 + (i*30)).size(30, 20).attr({label:{text:'1:2'}}).addTo(graph);
        new joint.shapes.standard.Link().source(edfa, {port:'out_'+i}).target(sp12, {port:'in'}).addTo(graph);
        new joint.shapes.standard.Link().source(sp12, {port:'out'}).target(odf, {port:'in_'+(i*2-1)}).addTo(graph);
        new joint.shapes.standard.Link().source(sp12, {port:'out'}).target(odf, {port:'in_'+(i*2)}).addTo(graph);
    }

    // 2. MUFA 1 (Distribución Principal)
    const mufa1 = new Hardware().position(400, 400).size(400, 680).attr({label:{text:'MUFA 1 (DISTRIBUCIÓN)'}, body:{fill:'#34495e', rx:15}}).addTo(graph);
    
    const b1_m1 = new Bandeja().position(420, 430).size(360, 180).attr({label:{text:'B1: CTO 1-4'}}).addTo(graph);
    const b2_m1 = new Bandeja().position(420, 630).size(360, 180).attr({label:{text:'B2: CTO 5-8'}}).addTo(graph);
    const b3_m1 = new Bandeja().position(420, 830).size(360, 220).attr({label:{text:'B3: TRANSITO A MUFA 2'}}).addTo(graph);
    [b1_m1, b2_m1, b3_m1].forEach(b => mufa1.embed(b));

    // 3. MUFA 2 (Bajo Mufa 1)
    const mufa2 = new Hardware().position(400, 1150).size(400, 480).attr({label:{text:'MUFA 2 (EXPANSIÓN)'}, body:{fill:'#2c3e50', rx:15}}).addTo(graph);
    const b1_m2 = new Bandeja().position(420, 1180).size(360, 180).attr({label:{text:'B1: CTO 9-12'}}).addTo(graph);
    const b2_m2 = new Bandeja().position(420, 1380).size(360, 180).attr({label:{text:'B2: CTO 13-16'}}).addTo(graph);
    [b1_m2, b2_m2].forEach(b => mufa2.embed(b));

    // --- LÓGICA DE DISTRIBUCIÓN ---

    function setupMufaTray(bandeja, hiloA, hiloB, startCto, xCto, source) {
        const spA = new Splitter().position(bandeja.position().x + 50, bandeja.position().y + 50).size(45, 30).attr({label:{text:'1:4'}}).addTo(graph);
        const spB = new Splitter().position(bandeja.position().x + 50, bandeja.position().y + 120).size(45, 30).attr({label:{text:'1:4'}}).addTo(graph);
        bandeja.embed(spA); bandeja.embed(spB);

        // Alimentación
        new joint.shapes.standard.Link().source(source.obj, {port:hiloA}).target(spA, {port:'in'})
            .attr({line:{stroke: source.colorA || '#409EFF', strokeWidth: 2}}).addTo(graph);
        new joint.shapes.standard.Link().source(source.obj, {port:hiloB}).target(spB, {port:'in'})
            .attr({line:{stroke: source.colorB || '#E6A23C', strokeWidth: 2}}).addTo(graph);

        for(let i=0; i<4; i++) {
            const cto = new CTO().position(xCto, bandeja.position().y + 15 + (i*40)).size(55, 25).attr({label:{text:'CTO '+(startCto+i)}}).addTo(graph);
            new joint.shapes.standard.Link().source(spA, {port:'out'}).target(cto, {port:'in'}).attr({line:{strokeWidth:1, stroke:'#909399'}}).addTo(graph);
            new joint.shapes.standard.Link().source(spB, {port:'out'}).target(cto, {port:'in'}).attr({line:{strokeWidth:1, stroke:'#C0C4CC', strokeDasharray:'2,2'}}).addTo(graph);
        }
        return { spA, spB };
    }

    // Configurar Bandejas Mufa 1
    setupMufaTray(b1_m1, 'out_1', 'out_5', 1, 900, {obj: odf, colorA: COLORES[0], colorB: COLORES[4]});
    setupMufaTray(b2_m1, 'out_2', 'out_6', 5, 900, {obj: odf, colorA: COLORES[1], colorB: COLORES[5]});

    // --- BANDEJA 3: FUSIONES DE TRÁNSITO ---
    const fusionPorts = ['f1','f2','f3','f4'];
    b3_m1.prop('ports/groups/fusion', {
        position: { name: 'line', args: { start: { x: 180, y: 50 }, end: { x: 180, y: 180 } } },
        attrs: { circle: { r: 5, fill: '#F56C6C', magnet: true } }
    });
    fusionPorts.forEach((f, i) => b3_m1.addPort({ id: f, group: 'fusion', label: { text: 'EMP '+(i+1), attrs: { text: { fontSize: 8, fill: '#303133'} } } }));

    // Conexiones ODF -> B3
    const mapping = [
        { odf: 3, f: 'f1', cIn: COLORES[2], cOut: COLORES[0], lbl: 'AZUL' },
        { odf: 4, f: 'f2', cIn: COLORES[3], cOut: COLORES[1], lbl: 'NARANJA' },
        { odf: 7, f: 'f3', cIn: COLORES[6], cOut: COLORES[2], lbl: 'VERDE' },
        { odf: 8, f: 'f4', cIn: COLORES[7], cOut: COLORES[3], lbl: 'CAFÉ' }
    ];

    mapping.forEach(m => {
        new joint.shapes.standard.Link().source(odf, {port:'out_'+m.odf}).target(b3_m1, {port:m.f})
            .attr({line:{stroke: m.cIn, strokeWidth: 2}}).addTo(graph);
    });

    // --- CONFIGURAR MUFA 2 DESDE FUSIONES ---
    const sp9 = new Splitter().position(b1_m2.position().x + 50, b1_m2.position().y + 50).size(45, 30).attr({label:{text:'1:4'}}).addTo(graph);
    const sp10 = new Splitter().position(b1_m2.position().x + 50, b1_m2.position().y + 120).size(45, 30).attr({label:{text:'1:4'}}).addTo(graph);
    const sp11 = new Splitter().position(b2_m2.position().x + 50, b2_m2.position().y + 50).size(45, 30).attr({label:{text:'1:4'}}).addTo(graph);
    const sp12 = new Splitter().position(b2_m2.position().x + 50, b2_m2.position().y + 120).size(45, 30).attr({label:{text:'1:4'}}).addTo(graph);

    const interLinks = [
        { f: 'f1', to: sp9, c: COLORES[0] },  // Azul
        { f: 'f3', to: sp10, c: COLORES[2] }, // Verde
        { f: 'f2', to: sp11, c: COLORES[1] }, // Naranja
        { f: 'f4', to: sp12, c: COLORES[3] }  // Café
    ];

    interLinks.forEach(m => {
        const l = new joint.shapes.standard.Link().source(b3_m1, {port:m.f}).target(m.to, {port:'in'});
        l.attr({line:{stroke: m.c, strokeWidth: 2.5, strokeDasharray: '4,2'}});
        l.router('manhattan', { padding: 30, startDirections: ['left'], endDirections: ['left'] });
        l.vertices([{x: 300, y: 1000}, {x: 300, y: m.to.position().y + 15}]);
        l.addTo(graph);
    });

    // CTOs 9-16
    function finishMufa2(spA, spB, start, tray) {
        for(let i=0; i<4; i++) {
            const cto = new CTO().position(900, tray.position().y + 15 + (i*40)).size(55, 25).attr({label:{text:'CTO '+(start+i)}}).addTo(graph);
            new joint.shapes.standard.Link().source(spA, {port:'out'}).target(cto, {port:'in'}).attr({line:{stroke:'#909399', strokeWidth:1}}).addTo(graph);
            new joint.shapes.standard.Link().source(spB, {port:'out'}).target(cto, {port:'in'}).attr({line:{stroke:'#C0C4CC', strokeWidth:1, strokeDasharray:'2,2'}}).addTo(graph);
        }
    }

    finishMufa2(sp9, sp10, 9, b1_m2);
    finishMufa2(sp11, sp12, 13, b2_m2);

    // Navegación fluida
    let isDown = false; let startX, startY, scrollLeft, scrollTop;
    const container = document.getElementById('paper-container');
    container.addEventListener('mousedown', (e) => { isDown = true; startX = e.pageX - container.offsetLeft; startY = e.pageY - container.offsetTop; scrollLeft = container.scrollLeft; scrollTop = container.scrollTop; });
    container.addEventListener('mouseleave', () => isDown = false);
    container.addEventListener('mouseup', () => isDown = false);
    container.addEventListener('mousemove', (e) => { if (!isDown) return; e.preventDefault(); const x = e.pageX - container.offsetLeft; const y = e.pageY - container.offsetTop; container.scrollLeft = scrollLeft - (x - startX); container.scrollTop = scrollTop - (y - startY); });

</script>
</body>
</html>