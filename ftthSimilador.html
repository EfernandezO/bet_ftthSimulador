<!DOCTYPE html>
<html lang="es">
    //usamdo jointjs para crear un diagrama de red FTTH con OLT, EDFA, ODF, MUFA y CTOs, con navegación por scroll y clic para simular cortes en los cables. El fondo es oscuro para resaltar los colores de fibra óptica. Se aplican efectos visuales para mostrar el impacto de los cortes en la red.
    //asistido por gemini de google
    //04/2026   
    //ELIASFERNANDEZO@GMAIL.COM
<head>
    <meta charset="UTF-8">
    <title>FTTH - Topología OLT a Mufa</title>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jointjs/3.7.7/joint.min.css"/>
    <style>
        body, html { margin: 0; padding: 0; width: 100%; height: 100%; background-color: #1a1a1a; overflow: hidden; }
        
        /* CONTENEDOR DE NAVEGACIÓN: Este es el que permite el scroll */
        #paper-container { 
            width: 100vw; 
            height: 100vh; 
            background-color: #f8f9fa; 
            overflow: auto; /* Habilita barras de scroll si es necesario */
            cursor: grab; 
            position: relative;
        }
        #paper-container:active { cursor: grabbing; }

        /* EL LIENZO REAL: Debe ser lo suficientemente grande para contener todo */
        #joint-canvas {
            width: 4000px;
            height: 3000px;
        }
        .controls {
            position: fixed; top: 10px; left: 10px; z-index: 100;
            background: white; padding: 15px; border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.4); width: 250px;
            pointer-events: none; /* No interfiere con los clics */
        }
        /* Clase para elementos afectados */
       /* Solo opacidad para los afectados, sin tocar los sanos */
        .element-affected {
            opacity: 0.3;
            filter: saturate(0.5); /* Baja un poco el color sin volverlo negro */
            transition: opacity 0.5s ease;
        }

        /* El link afectado mantiene su rojo vibrante */
        .link-affected {
            stroke: #ff0000 !important;
            stroke-width: 4 !important;
            stroke-dasharray: 5, 5;
            animation: dash 1s linear infinite;
        }

        @keyframes dash {
            to { stroke-dashoffset: -20; }
        }
    </style>
</head>
<body>
<div class="controls">
    <strong>Configuración de Red</strong><br>
    <small>OLT -> EDFA -> ODF -> MUFA 1</small><br>
    <small><b>Navegación:</b> Haz clic y arrastra el fondo para moverte por el mapa.</small>
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
    width: 5000, 
    height: 4000, 
    gridSize: 20, // Rejilla un poco más amplia para limpieza visual
    drawGrid: { 
        name: 'dot', 
        args: { color: '#34495e', thickness: 1.5 } // Puntos sutiles pero visibles
    },
    background: { 
        color: '#121416' // Gris casi negro: resalta todos los colores de fibra
    },
    defaultRouter: { name: 'manhattan', args: { step: 10, padding: 25 } },
    defaultConnector: { name: 'rounded' },
    interactive: { linkMove: false }
});

    const codigoColores = [
    '#0055FF', // Azul (más brillante)
    '#FF6600', // Naranja
    '#2ecc71', // Verde (Esmeralda)
    '#A52A2A', // Café
    '#95a5a6', // Gris
    '#FFFFFF', // Blanco (Resaltará perfecto ahora)
    '#FF0000', // Rojo
    '#000000', // Negro (Nota: sobre fondo negro, este debe llevar un 'glow' o ser gris oscuro)
    '#FFFF00', // Amarillo
    '#D100D1', // Púrpura
    '#FFC0CB', // Rosa
    '#00FFFF'  // Aqua
];

    // --- DEFINICIONES DE COMPONENTES (TU DISEÑO) ---

    joint.shapes.standard.Rectangle.define('olt.tarjeta', {
        attrs: {
            body: { fill: '#ecf0f1', stroke: '#bdc3c7', strokeWidth: 2, rx: 4 },
            label: { text: 'Tarjeta GPON', fill: '#2c3e50', fontSize: 12, refY: 10, fontWeight: 'bold' }
        },
        ports: {
            groups: {
                'pon': {
                    position: { name: 'grid', args: { columns: 1, columnWidth: 40, rowHeight: 5, dx: 40, dy: 10 } },
                    attrs: {
                        circle: { r: 3, fill: '#2980b9', stroke: '#dd0e0e' },
                        text: { fontSize: 9, fill: '#333', fontWeight: 'bold' }
                    },
                    label: { position: { name: 'bottom', args: { y: 6 } } }
                }
            }
        }
    });

    joint.shapes.standard.Polygon.define('Splitter1x2', {
        attrs: {
            body: { refPoints: '0,10 20,0 20,20', fill: '#e67e22', stroke: '#d35400', strokeWidth: 2 },
            label: { text: '1:2', fill: 'white', fontSize: 8, refX: '60%', refY: '50%' }
        },
        ports: {
            groups: {
                'in': { position: { name: 'left' }, attrs: { circle: { r: 3, fill: '#3498db' } } },
                'out': { position: { name: 'right' }, attrs: { circle: { r: 3 } } }
            }
        }
    });

    joint.shapes.standard.Rectangle.define('ODF', {
        attrs: {
            body: { fill: '#2c3e50', stroke: '#2c3e50', strokeWidth: 2, rx: 2 },
            label: { text: 'ODF', fill: 'white', fontSize: 14, fontWeight: 'bold', refY: 20 }
        },
        ports: {
            groups: {
                'in': {
                    position: { name: 'left' },
                    markup: [{ tagName: 'rect', selector: 'portBody' }],
                    attrs: { portBody: { width: 10, height: 10, x: -5, y: -5, fill: '#95a5a6', magnet: true } }
                },
                'out': {
                    position: { name: 'right' },
                    markup: [{ tagName: 'rect', selector: 'portBody' }],
                    attrs: { portBody: { width: 10, height: 10, x: -5, y: -5, fill: '#27ae60', magnet: true } }
                }
            }
        }
    });

    joint.shapes.standard.Rectangle.define('Bandeja', {
        attrs: {
            body: { fill: 'rgba(255, 255, 255, 0.9)', stroke: '#7f8c8d', strokeWidth: 1, rx: 5 },
            label: { fill: '#2c3e50', fontSize: 11, fontWeight: 'bold', refY: 5 }
        },
        ports: { groups: { 'in': { position: { name: 'left' }, attrs: { circle: { r: 4, fill: '#bdc3c7' } } } } }
    });

     // --- DEFINICIÓN DE SPLITTER TRIANGULAR 1x4 ---
    joint.shapes.standard.Polygon.define('splitter1x4', {
        attrs: {
            body: { 
                refPoints: '0,30 60,0 60,60', // Punta en 0,30 (izquierda)
                fill: '#f39c12', stroke: '#e67e22', strokeWidth: 2 
            },
            label: { text: '1x4', fill: 'white', fontSize: 10, fontWeight: 'bold', refX: '70%', refY: '50%' }
        },
        ports: {
            groups: {
                'in': { position: { name: 'left' }, attrs: { circle: { r: 5, fill: '#3498db', magnet: true } } },
                'out': { position: { name: 'right' }, attrs: { circle: { r: 3, fill: '#2ecc71', magnet: true } } }
            }
        }
    });

    joint.shapes.standard.Rectangle.define('M1_bandeja_fusiones', {
    attrs: {
        body: { fill: 'rgba(255, 255, 255, 0.9)', stroke: '#7f8c8d', strokeWidth: 1, rx: 5 },
        label: { fill: '#2c3e50', fontSize: 11, fontWeight: 'bold', refY: 5 }
    },
    // Actualiza o asegúrate de que tu definición de Bandeja tenga este grupo:
ports: {
    groups: {
        'fusion': {
            // 'line' vertical: x constante al centro (230 de 460), y distribuida
            position: { 
                name: 'line', 
                args: { 
                    start: { x: 230, y: 50 }, 
                    end: { x: 230, y: 115 } 
                } 
            },
            attrs: {
                circle: { r: 4, fill: '#e74c3c', stroke: '#c0392b', strokeWidth: 2, magnet: true }
            },
            label: { 
                position: { name: 'right', args: { x: 10 } }, // Etiqueta a la derecha del punto
                attrs: { text: { fontSize: 10, fill: '#2c3e50', fontWeight: 'bold' } }
            }
        }
    }
}
});

 // Elemento CTO (Con 2 puertos espaciados)
    joint.shapes.standard.Rectangle.define('CTO', {
        attrs: {
            body: { fill: '#ecf0f1', stroke: '#2c3e50', strokeWidth: 2, rx: 4 },
            label: { text: 'CTO', fill: '#2c3e50', fontSize: 12, fontWeight: 'bold', refY: -15 }
        },
        ports: {
            groups: {
                'in': { position: { name: 'left' }, attrs: { circle: { r: 4, fill: '#e74c3c' } } }
            }
        }
    });
    // --- INSTANCIACIÓN ---

    const OLT = new joint.shapes.standard.Rectangle().position(85, 130).size(100, 310)
        .attr({ body: { fill: '#2ecc71', stroke: '#1a252f', strokeWidth: 4, rx: 8 }, label: { text: 'OLT 1', fill: 'white', refY: 15 } }).addTo(graph);
    
    const card1 = new joint.shapes.olt.tarjeta().position(90, 155).size(90, 280).addTo(graph);
    OLT.embed(card1);
    for(let p=1; p<=16; p++) {
        card1.addPort({ group: 'pon', id: 'olt1_pon_1/'+p, label: { text: '1/' + p } });
    }




    const edfa = new joint.shapes.standard.Rectangle().position(250, 130).size(90, 310)
    .attr({ 
        body: { fill: '#16a085', stroke: '#0e6251', strokeWidth: 3 }, 
        label: { text: 'EDFA', fill: 'white', refY: 20 } // Bajamos un poco la etiqueta para que no choque
    })
    .prop('ports', {
        groups: {
            'left': { 
                position: { 
                    name: 'line', 
                    args: { 
                        // Definimos la línea de puertos en el borde izquierdo (x: 0)
                        // Empezamos en y: 40 y terminamos en y: 100 para que estén juntos arriba
                        start: { x: 0, y: 40 }, 
                        end: { x: 0, y: 130 } 
                    } 
                }, 
                attrs: { circle: { r: 5, fill: '#f1c40f' } } 
            },
            'right': { 
                position: { 
                    name: 'line', 
                    args: { 
                        // Definimos la línea de puertos en el borde izquierdo (x: 0)
                        // Empezamos en y: 40 y terminamos en y: 100 para que estén juntos arriba
                        start: { x: 90, y: 40 }, 
                        end: { x: 90, y: 150 } 
                    } 
                }, 
                attrs: { circle: { r: 5, fill: '#f1c40f' } } 
            }
        }
    }).addTo(graph);    

    for (let i = 1; i <= 4; i++) {
        edfa.addPorts([{ id: 'edfa1_in_'+i, group: 'left' }, { id: 'edfa1_out_'+i, group: 'right' }]);

        const oltY = OLT.position().y;
        const oltHeight = OLT.size().height;
        const numeroPuerto ='olt1_pon_1/'+i;
        const puertoY = 150 + (i * (oltHeight / 17));;

        new joint.shapes.standard.Link()
            .source(card1, { port: 'olt1_pon_1/'+i })
            .target(edfa, { port: 'edfa1_in_'+i })
            .attr({ line: { stroke: '#ffd700', strokeWidth: 2 } })
            .router('manhattan', { padding: 40, startDirections: ['right'], endDirections: ['left'] })
            
            .addTo(graph);
            console.log('Link creado desde OLT puerto 1/' + i + ' a EDFA puerto edfa1_in_' + i, 'Posición Y del puerto en OLT:', puertoY);
    }

    const odf = new joint.shapes.ODF().position(560, 130).size(90, 320).addTo(graph);
    for (let i = 1; i <= 12; i++) {
        odf.addPorts([{ id: 'odf_in_'+i, group: 'in' }, { id: 'odf_out_'+i, group: 'out' }]);
    }

    for (let i = 1; i <= 4; i++) {
        const sp = new joint.shapes.Splitter1x2().position(450, 130 + ((i-1) * 70)).size(40, 30).addTo(graph);
        sp.addPorts([{ id: 'in', group: 'in' }, { id: 'out_a', group: 'out' }, { id: 'out_b', group: 'out' }]);
        
        new joint.shapes.standard.Link().source(edfa, { port: 'edfa1_out_'+i }).target(sp, { port: 'in' }).addTo(graph);
        new joint.shapes.standard.Link().source(sp, { port: 'out_a' }).target(odf, { port: 'odf_in_'+(i*2-1) }).attr({line:{stroke:'#0000FF'}}).addTo(graph);
        new joint.shapes.standard.Link().source(sp, { port: 'out_b' }).target(odf, { port: 'odf_in_'+(i*2) }).attr({line:{stroke:'#FF6600'}}).addTo(graph);
    }

   // 2. MUFA 1
    const mufa1 = new joint.shapes.standard.Rectangle().position(800, 130).size(170, 320)
        .attr({ body: { fill: '#34495e', rx: 20, stroke: '#2c3e50', strokeWidth: 4 }, label: { text: 'MUFA 1', fill: 'white', refY: 10, fontSize: 20 } }).addTo(graph);

    const b1_m1 = new joint.shapes.Bandeja().position(810, 150).size(150,90).attr({label:{text:'BANDEJA 1 (CTO 1-4)'}}).addTo(graph);
    const b2_m1 = new joint.shapes.Bandeja().position(810, 250).size(150, 90).attr({label:{text:'BANDEJA 2 (CTO 5-8)'}}).addTo(graph);
    const b3_m1 = new joint.shapes.Bandeja().position(810, 350).size(150, 90).attr({label:{text:'BANDEJA 3 (Fusiones)'}}).addTo(graph);
    [b1_m1, b2_m1, b3_m1].forEach(b => mufa1.embed(b));

    // 3. MUFA 2 (Bajo la MUFA 1)
    const mufa2 = new joint.shapes.standard.Rectangle().position(800, 600).size(170, 320)
        .attr({ body: { fill: '#2c3e50', rx: 20, stroke: '#1a252f', strokeWidth: 4 }, label: { text: 'MUFA 2', fill: 'white', refY: 10, fontSize: 20 } }).addTo(graph);

    const b1_m2 = new joint.shapes.Bandeja().position(810, 620).size(150, 90).attr({label:{text:'BANDEJA 1 (CTO 9-12)'}}).addTo(graph);
    const b2_m2 = new joint.shapes.Bandeja().position(810, 720).size(150, 90).attr({label:{text:'BANDEJA 2 (CTO 13-16)'}}).addTo(graph);
    [b1_m2, b2_m2].forEach(b => mufa2.embed(b));

    // --- FUNCIÓN PARA CREAR SPLITTERS Y CTOS ---
    function configurarBandejaYCTOs(bandeja, hiloA, hiloB, startNum, xCto, sourceObj) {
        const spA = new joint.shapes.splitter1x4().position(bandeja.position().x + 40, bandeja.position().y + 10).size(40, 30).attr({label:{text:'A'}}).addTo(graph);
        const spB = new joint.shapes.splitter1x4().position(bandeja.position().x + 40, bandeja.position().y + 50).size(40, 30).attr({label:{text:'B'}}).addTo(graph);
        spA.addPort({ id: 'in', group: 'in' }); spB.addPort({ id: 'in', group: 'in' });
        bandeja.embed(spA); bandeja.embed(spB);

        // Link desde Fuente (ODF o Fusiones)
        new joint.shapes.standard.Link().source(sourceObj.obj, { port: hiloA }).target(spA, { port: 'in' })
            .attr({ line: { stroke: sourceObj.colorA || '#3498db', strokeWidth: 3 } }).addTo(graph);
        new joint.shapes.standard.Link().source(sourceObj.obj, { port: hiloB }).target(spB, { port: 'in' })
            .attr({ line: { stroke: sourceObj.colorB || '#e67e22', strokeWidth: 3 } }).addTo(graph);

        maximoPuerto=4;
        for(let i=1; i<=4; i++) {
            let num = startNum + i - 1;
            spA.addPort({ id: 'out_'+i, group: 'out' }); spB.addPort({ id: 'out_'+i, group: 'out' });
            
            const cto = new joint.shapes.CTO().position(xCto +(i-1)*80 , bandeja.position().y+30 ).size(70, 35).attr({label:{text:'CTO '+num, refY: 15}}).addTo(graph);
            cto.addPort({ id: 'i1', group: 'in' }); cto.addPort({ id: 'i2', group: 'in' });

            new joint.shapes.standard.Link().source(spA, { port: 'out_'+maximoPuerto }).target(cto, { port: 'i1' }).attr({line:{stroke:'#2980b9'}}).addTo(graph);
            new joint.shapes.standard.Link().source(spB, { port: 'out_'+i }).target(cto, { port: 'i2' }).attr({line:{stroke:'#d35400'}}).addTo(graph);
            maximoPuerto--;
        }
        
        return { spA, spB };
    }

    // --- IMPLEMENTACIÓN MUFA 1 ---
    configurarBandejaYCTOs(b1_m1, 'odf_out_1', 'odf_out_5', 1, 1100, {obj: odf, colorA: codigoColores[0], colorB: codigoColores[4]});
    configurarBandejaYCTOs(b2_m1, 'odf_out_2', 'odf_out_6', 5, 1100, {obj: odf, colorA: codigoColores[1], colorB: codigoColores[5]});

    // --- BANDEJA 3 (FUSIONES) ---
    b3_m1.prop('ports/groups/fusion', {
        position: { name: 'line', args: { start: { x: 90, y: 10 }, end: { x: 45, y: 90 } } },
        attrs: { circle: { r: 4, fill: '#e74c3c', stroke: '#c0392b', strokeWidth: 2, magnet: true } },
        label: { position: 'right', attrs: { text: { fontSize: 10, fontWeight: 'bold' } } }
    });
    const fPorts = ['f1','f2','f3','f4'];
    fPorts.forEach((f, i) => b3_m1.addPort({ id: f, group: 'fusion', label: { text: 'EMP ' + (i+1) } }));

    // Conectar ODF a Fusiones (H3, H4, H7, H8)
    const transitMapping = [
        { odfPort: 'odf_out_3', fPort: 'f1', color: codigoColores[2], outColor: codigoColores[0], targetLabel: 'AZUL' },   // Verde -> Azul
        { odfPort: 'odf_out_4', fPort: 'f2', color: codigoColores[3], outColor: codigoColores[1], targetLabel: 'NARANJA' },// Café -> Naranja
        { odfPort: 'odf_out_7', fPort: 'f3', color: codigoColores[6], outColor: codigoColores[2], targetLabel: 'VERDE' },  // Rojo -> Verde
        { odfPort: 'odf_out_8', fPort: 'f4', color: codigoColores[7], outColor: codigoColores[3], targetLabel: 'CAFÉ' }    // Negro -> Café
    ];

    j=0;
    transitMapping.forEach(m => {

        // 1. Obtenemos la posición Y base del ODF
        const odfY = odf.position().y;
        const odfHeight = odf.size().height;

        // 2. Extraemos el número de puerto del ID (ej: de "odf_out_3" extraemos el 3)
        const numeroPuerto = parseInt(m.odfPort.split('_').pop());

        // 3. Calculamos la Y exacta del puerto. 
        // Como JointJS distribuye 12 puertos en 320px de alto:
        const puertoY = odfY + (numeroPuerto * (odfHeight / 13));

        const link = new joint.shapes.standard.Link()
        link.source(odf, { port: m.odfPort })
        link.target(b3_m1, { port: m.fPort })
        link.attr({ line: { stroke: m.color, strokeWidth: 2.5 } })
        link.router('manhattan', { padding: 40, startDirections: ['right'], endDirections: ['left'] });
        link.vertices([{ x: 750 - (j*15) , y: puertoY},{ x: 750 - (j*15) , y: 350 + (j*5) }]);
        link.addTo(graph);
        j++;
    });

  
    // --- IMPLEMENTACIÓN MUFA 2 ---
    // Creamos los Splitters de MUFA 2 manualmente para conectarlos a las fusiones de MUFA 1
    const sp9 = new joint.shapes.splitter1x4().position(b1_m2.position().x + 40, b1_m2.position().y + 10).size(40, 30).attr({label:{text:'A'}}).addTo(graph);
    const sp10 = new joint.shapes.splitter1x4().position(b1_m2.position().x + 40, b1_m2.position().y + 50).size(40, 30).attr({label:{text:'B'}}).addTo(graph);
    const sp11 = new joint.shapes.splitter1x4().position(b2_m2.position().x + 40, b2_m2.position().y + 10).size(40, 30).attr({label:{text:'A'}}).addTo(graph);
    const sp12 = new joint.shapes.splitter1x4().position(b2_m2.position().x + 40, b2_m2.position().y + 50).size(40, 30).attr({label:{text:'B'}}).addTo(graph);
    
    [sp9, sp10, sp11, sp12].forEach(s => s.addPort({ id: 'in', group: 'in' }));
    b1_m2.embed(sp9); b1_m2.embed(sp10); b2_m2.embed(sp11); b2_m2.embed(sp12);

    // Links Inter-Mufa (FUSIÓN -> SPLITTER) con cambio de color
    const interMufaLinks = [
        { from: 'f1', to: sp9, color: codigoColores[0] },  // Azul
        { from: 'f2', to: sp11, color: codigoColores[1] }, // Naranja
        { from: 'f3', to: sp10, color: codigoColores[2] }, // Verde
        { from: 'f4', to: sp12, color: codigoColores[3] }  // Café
    ];

    aux=0;
    interMufaLinks.forEach(m => {
        const link = new joint.shapes.standard.Link().source(b3_m1, { port: m.from }).target(m.to, { port: 'in' });
        link.attr({ line: { stroke: m.color, strokeWidth: 3 } });
        link.router('manhattan', { padding: 40, startDirections: ['left'], endDirections: ['left'] });
        link.vertices([{ x: 800 , y: 580 - aux }, { x: 700-aux, y: m.to.position().y + 10 }]);
        link.addTo(graph);
        aux += 10; // Para separar un poco las líneas de conexión entre MUFAs
    });

    // Crear CTOs 9-16
    function crearCTOsFinales(spA, spB, startNum, xCto, bandeja) {
        posicionY=0;
        for(let i=1; i<=4; i++) {
            let num = startNum + i - 1;
            spA.addPort({ id: 'out_'+i, group: 'out' }); spB.addPort({ id: 'out_'+i, group: 'out' });
            
           // const cto = new joint.shapes.CTO().position(xCto +(i-1)*80 , bandeja.position().y - ((i-1)*70)).size(70, 35).attr({label:{text:'CTO '+num, refY: 15}}).addTo(graph);
            if(num>12){
                Yposicion=bandeja.position().y + ((i-1)*70);
            } else {
                Yposicion=bandeja.position().y - ((i-1)*70);
            }
            const cto = new joint.shapes.CTO().position(xCto +(i-1)*80 , Yposicion).size(70, 35).attr({label:{text:'CTO '+num, refY: 15}}).addTo(graph);
            
            cto.addPort({ id: 'i1', group: 'in' }); cto.addPort({ id: 'i2', group: 'in' });
            new joint.shapes.standard.Link().source(spA, { port: 'out_'+i }).target(cto, { port: 'i1' }).attr({line:{stroke:'#2980b9'}}).addTo(graph);
            new joint.shapes.standard.Link().source(spB, { port: 'out_'+i }).target(cto, { port: 'i2' }).attr({line:{stroke:'#d35400'}}).addTo(graph);
        }
    }

    crearCTOsFinales(sp9, sp10, 9, 1100, b1_m2);
    crearCTOsFinales(sp11, sp12, 13, 1100, b2_m2);

    // --- NAVEGACIÓN ---
    let isDown = false; let startX, startY, scrollLeft, scrollTop;
    const container = document.getElementById('paper-container');
    container.addEventListener('mousedown', (e) => { isDown = true; startX = e.pageX - container.offsetLeft; startY = e.pageY - container.offsetTop; scrollLeft = container.scrollLeft; scrollTop = container.scrollTop; });
    container.addEventListener('mouseleave', () => isDown = false);
    container.addEventListener('mouseup', () => isDown = false);
    container.addEventListener('mousemove', (e) => { if (!isDown) return; const x = e.pageX - container.offsetLeft; const y = e.pageY - container.offsetTop; container.scrollLeft = scrollLeft - (x - startX); container.scrollTop = scrollTop - (y - startY); });

/////////////////////////////////////////////////////////

paper.on('link:pointerclick', function(linkView) {
    const link = linkView.model;
    
    // Toggle del estado de corte
    const estaCortado = link.get('cortado') || false;
    link.set('cortado', !estaCortado);

    // Ejecutar la actualización global de la red
    actualizarEstadoRed();
});

/////////////////////////////////////////////////////////
function actualizarEstadoRed() {
    const todosLosLinks = graph.getLinks();
    const todosLoselementos = graph.getElements();

    // 1. Resetear visuales (manteniendo colores originales)
    todosLosLinks.forEach(l => {
        const colorOriginal = l.get('originalColor') || l.attr('line/stroke');
        if (!l.get('originalColor')) l.set('originalColor', colorOriginal);

        l.attr({ line: { stroke: colorOriginal, strokeDasharray: '0', strokeWidth: 2 } });
        l.set('tieneLuz', true); // Por defecto todos tienen luz hasta que se demuestre lo contrario
    });

    todosLoselementos.forEach(e => {
        const view = paper.findViewByModel(e);
        if (view) view.el.classList.remove('element-affected');
    });

    // 2. Aplicar cortes visuales de los cables clickeados por el usuario
    todosLosLinks.forEach(l => {
        if (l.get('cortado')) {
            l.attr({ line: { stroke: '#ff0000', strokeDasharray: '5,5', strokeWidth: 4 } });
            l.set('tieneLuz', false);
        }
    });

    // 3. PROPAGACIÓN DE SOMBRA (Rastreo desde la OLT)
    // Buscamos los links que salen de la OLT como punto de partida
    const linksRaiz = graph.getConnectedLinks(OLT, { outbound: true });
    
    // Función para apagar lo que no recibe luz
    function propagarSombra(elemento, puertoEntradaAfectado) {
        // Obtenemos qué puertos de salida se ven afectados por esa entrada
        let salidasAfectadas = obtenerPuertosSalidaAfectados(elemento, puertoEntradaAfectado);

        const linksSalientes = graph.getConnectedLinks(elemento, { outbound: true });
        
        linksSalientes.forEach(link => {
            if (salidasAfectadas.includes(link.get('source').port)) {
                // Apagamos este link y seguimos propagando
                link.set('tieneLuz', false);
                link.attr({ line: { stroke: '#ff0000', strokeDasharray: '5,5', strokeWidth: 4 } });
                
                const siguienteElemento = graph.getCell(link.get('target').id);
                if (siguienteElemento) {
                    propagarSombra(siguienteElemento, link.get('target').port);
                }
            }
        });

        // Si todas las entradas de un elemento final (como CTO) están apagadas, marcar elemento
        const view = paper.findViewByModel(elemento);
        if (view) view.el.classList.add('element-affected');
    }

    // Ejecutamos la propagación para cada link que el usuario haya cortado
    todosLosLinks.forEach(l => {
        if (l.get('cortado') === true) {
            const elementoDestino = graph.getCell(l.get('target').id);
            if (elementoDestino) {
                propagarSombra(elementoDestino, l.get('target').port);
            }
        }
    });
}

// Función auxiliar para centralizar la lógica de mapeo que ya teníamos
function obtenerPuertosSalidaAfectados(elemento, puertoEntrada) {
    let salidas = [];
    const textoElemento = elemento.attr('label/text') || "";

    if (puertoEntrada && puertoEntrada.includes('edfa1_in_')) {
        salidas.push('edfa1_out_' + puertoEntrada.split('_').pop());
    }
    else if (textoElemento === 'ODF' && puertoEntrada && puertoEntrada.includes('odf_in_')) {
        salidas.push('odf_out_' + puertoEntrada.split('_').pop());
    }
    else if (elemento.get('type').toLowerCase().includes('splitter')) {
        salidas = elemento.getPorts().filter(p => p.group === 'out').map(p => p.id);
    }
    else if (puertoEntrada && (puertoEntrada.startsWith('f') || puertoEntrada.includes('fusion'))) {
        salidas.push(puertoEntrada);
    }
    return salidas;
}
/////////////////////////////////////////////////////////
  
</script>
</body>
</html>