//from https://codepen.io/TP24/pen/zVWYGX

(function() {

    //http://mike.teczno.com/notes/canvas-warp.html
    //http://s3.amazonaws.com/canvas-warp/2009-11-01/index.html
    const utils = {

        rndInt(max, override) {
            //if(override !== undefined) { return override; }
            return Math.round(Math.random() * max);
        },
        
        /**
         * https://en.wikipedia.org/wiki/Incircle_and_excircles_of_a_triangle
         * https://math.stackexchange.com/questions/1413372/find-cartesian-coordinates-of-the-incenter
         * https://www.mathopenref.com/coordincenter.html
         */
        calcIncircle(A, B, C) {
            function lineLen(p1, p2) {
                const dx = p2[0] - p1[0],
                      dy = p2[1] - p1[1];
                return Math.sqrt(dx*dx + dy*dy);
            }
            
            //Side lengths, perimiter p and semiperimiter s:
            const a = lineLen(B, C),
                  b = lineLen(C, A),
                  c = lineLen(A, B),
                  p = (a + b + c),
                  s = p/2;
            
            //Heron's formula
            //https://www.wikihow.com/Calculate-the-Area-of-a-Triangle#Using_Side_Lengths
            const area = Math.sqrt(s * (s-a) * (s-b) * (s-c));
            //Faster(?) alternative:
            //http://geomalgorithms.com/a01-_area.html#Modern-Triangles
            //const area = Math.abs( (B[0]-A[0])*(C[1]-A[1]) - (C[0]-A[0])*(B[1]-A[1]) )/2;

            //Incircle radius r
            //  https://en.wikipedia.org/wiki/Incircle_and_excircles_of_a_triangle#Relation_to_area_of_the_triangle
            //..and center [cx, cy]
            //  https://en.wikipedia.org/wiki/Incircle_and_excircles_of_a_triangle#Cartesian_coordinates
            //  https://www.mathopenref.com/coordincenter.html
            const r = area/s,
                  cx = (a*A[0] + b*B[0] + c*C[0]) / p,
                  cy = (a*A[1] + b*B[1] + c*C[1]) / p;
            return {
                r,
                c: [cx, cy],
            }
        },
        
        /*
         * https://math.stackexchange.com/questions/17561/how-to-shrink-a-triangle
         */
        expandTriangle(A, B, C, amount) {
            const incircle = this.calcIncircle(A, B, C),
                  c = incircle.c,
                  factor = (incircle.r + amount)/(incircle.r);
            
            function extendPoint(p) {
                const dx = p[0] - c[0],
                      dy = p[1] - c[1],
                      x2 = (dx * factor) + c[0],
                      y2 = (dy * factor) + c[1];
                return [x2, y2];
            }
            
            const A2 = extendPoint(A),
                  B2 = extendPoint(B),
                  C2 = extendPoint(C);
            return[A2, B2, C2];
        },

        /**
         *  Solves a system of linear equations.
         *
         *  t1 = (a * r1) + (b + s1) + c
         *  t2 = (a * r2) + (b + s2) + c
         *  t3 = (a * r3) + (b + s3) + c
         *
         *  r1 - t3 are the known values.
         *  a, b, c are the unknowns to be solved.
         *  returns the a, b, c coefficients.
         */
        linearSolution(r1, s1, t1, r2, s2, t2, r3, s3, t3)
        {
            var a = (((t2 - t3) * (s1 - s2)) - ((t1 - t2) * (s2 - s3))) / (((r2 - r3) * (s1 - s2)) - ((r1 - r2) * (s2 - s3)));
            var b = (((t2 - t3) * (r1 - r2)) - ((t1 - t2) * (r2 - r3))) / (((s2 - s3) * (r1 - r2)) - ((s1 - s2) * (r2 - r3)));
            var c = t1 - (r1 * a) - (s1 * b);

            return [a, b, c];
        },

        /**
         *  This draws a triangular area from an image onto a canvas,
         *  similar to how ctx.drawImage() draws a rectangular area from an image onto a canvas.
         *
         *  s1-3 are the corners of the triangular area on the source image, and
         *  d1-3 are the corresponding corners of the area on the destination canvas.
         *
         *  Those corner coordinates ([x, y]) can be given in any order,
         *  just make sure s1 corresponds to d1 and so forth.
         */
        drawImageTriangle(img, ctx, s1, s2, s3, d1, d2, d3) {
            //I assume the "m" is for "magic"...
            const xm = this.linearSolution(s1[0], s1[1], d1[0],  s2[0], s2[1], d2[0],  s3[0], s3[1], d3[0]),
                  ym = this.linearSolution(s1[0], s1[1], d1[1],  s2[0], s2[1], d2[1],  s3[0], s3[1], d3[1]);

            ctx.save();

            ctx.setTransform(xm[0], ym[0], xm[1], ym[1], xm[2], ym[2]);
            ctx.beginPath();
            ctx.moveTo(s1[0], s1[1]);
            ctx.lineTo(s2[0], s2[1]);
            ctx.lineTo(s3[0], s3[1]);
            ctx.closePath();
            //Leaves a faint black (or whatever .fillStyle) border around the drawn triangle
            //  ctx.fill();
            ctx.clip();
            ctx.drawImage(img, 0, 0, img.width, img.height);

            ctx.restore();
            
            return;
            
            //DEBUG - https://en.wikipedia.org/wiki/Incircle_and_excircles_of_a_triangle
            const incircle = this.calcIncircle(d1, d2, d3),
                  c = incircle.c;
            //console.log(incircle);
            ctx.beginPath();
            ctx.arc(c[0], c[1], incircle.r, 0, 2*Math.PI, false);
            ctx.moveTo(d1[0], d1[1]);
            ctx.lineTo(d2[0], d2[1]);
            ctx.lineTo(d3[0], d3[1]);
            ctx.closePath();
            //ctx.fillStyle = 'rgba(0,0,0, .3)';
            //ctx.fill();
            ctx.lineWidth = 2;
            ctx.strokeStyle = 'rgba(255,0,0, .4)';
            ctx.stroke();
            
        },
    };


    const cont = document.querySelector('#drag-wrapper');
    const canv = document.querySelector('#c'),
          ctx = canv.getContext('2d'),
          img = document.querySelector('#i'); //new Image(),
          //handles = document.querySelectorAll('.drag-handle');

    let w, h;
    let corners = [];
    let cornersMod = [];
    
    function updateUI() {

        function drawTriangle(s1, s2, s3, d1, d2, d3) {
            function movePoint(p, exampleSource, exampleTarget) {
                const dx = exampleTarget[0]/exampleSource[0],
                      dy = exampleTarget[1]/exampleSource[1],
                      p2 = [p[0] * dx, p[1] * dy];
                return p2;
            }
            //Overlap the destination areas a little
            //to avoid hairline cracks when drawing mulitiple connected triangles.
            const [d1x, d2x, d3x] = utils.expandTriangle(d1, d2, d3, .3),
                  [s1x, s2x, s3x] = utils.expandTriangle(s1, s2, s3, .3);
                  //s1x = movePoint(s1, d1, d1x),
                  //s2x = movePoint(s2, d2, d2x),
                  //s3x = movePoint(s3, d3, d3x);
            
            utils.drawImageTriangle(img, ctx,
                                    s1x, s2x, s3x,
                                    d1x, d2x, d3x);
        }

        ctx.clearRect(0,0, w,h);
        
                    
        generateTriangles(6, 6, w, h, cont);

        
        function generateTriangles(numCols, numRows, w, h, containerEl) {
            //corners = [];
            //cornersMod = [];
            const dx = w / numCols;
            const dy = h / numRows;


            // Step 1: Generate grid points (corners)
            if(corners.length === 0){
                // Clear old handles if re-generating
                if (containerEl) {
                    containerEl.querySelectorAll('.drag-handle').forEach(el => el.remove());
                }
                for (let row = 0; row <= numRows; row++) {
                    for (let col = 0; col <= numCols; col++) {
                        const x = col * dx;
                        const y = row * dy;
                        corners.push([x, y]);
                        cornersMod.push([x, y]);
                        //cornersMod.push([x + utils.rndInt(100)-50, y + utils.rndInt(100)-50]);

                        // Optionally create draggable handles
                        if (containerEl) {
                            const index = row * (numCols + 1) + col;
                            const handle = document.createElement('div');
                            handle.className = 'drag-handle';
                            handle.dataset.corner = index;
                            handle.textContent = index + 1; // or just index

                            // Position the handle (make sure your container is position: relative)
                            handle.style.position = 'absolute';
                            handle.style.left = `${x}px`;
                            handle.style.top = `${y}px`;

                            containerEl.appendChild(handle);
                        }
                    }
                }
            }

            // // Step 1: Generate grid points (corners)
            // for (let row = 0; row <= numRows; row++) {
            //     for (let col = 0; col <= numCols; col++) {
            //         corners.push([col * dx, row * dy]);
            //     }
            // }

            // Helper to get corner index
            function cornerIndex(col, row) {
                return row * (numCols + 1) + col;
            }

            // Step 2: Loop through each quad and make 2 triangles
            for (let row = 0; row < numRows; row++) {
                for (let col = 0; col < numCols; col++) {
                    const topLeftIdx = cornerIndex(col, row);
                    const topRightIdx = cornerIndex(col + 1, row);
                    const bottomLeftIdx = cornerIndex(col, row + 1);
                    const bottomRightIdx = cornerIndex(col + 1, row + 1);

                    const topLeft = corners[topLeftIdx];
                    const topRight = corners[topRightIdx];
                    const bottomLeft = corners[bottomLeftIdx];
                    const bottomRight = corners[bottomRightIdx];

                    // Triangle 1: top-left, bottom-left, center/bottom-right
                    drawTriangle(topLeft, bottomLeft, bottomRight,
                                cornersMod[topLeftIdx], cornersMod[bottomLeftIdx], cornersMod[bottomRightIdx]);

                    // Triangle 2: top-left, bottom-right, top-right
                    drawTriangle(topLeft, bottomRight, topRight,
                                cornersMod[topLeftIdx], cornersMod[bottomRightIdx], cornersMod[topRightIdx]);
                }
            }

    //return corners; // Useful if you want to mutate corners for displacements later
        }
        // drawTriangle([0, 0], [0, h/2], [w/2, h/2], 
        //             corners[0], corners[3], corners[4]);
                    
        // drawTriangle([0, 0], [w/2, 0], [w/2, h/2], 
        //             corners[0], corners[1], corners[4]);
                    
        // drawTriangle([w/2, 0], [w/2, h/2], [w, 0], 
        //             corners[1], corners[4], corners[2]);
                    
        // drawTriangle([w, 0], [w, h/2], [w/2, h/2], 
        //             corners[2], corners[5], corners[4]);
                    
        // drawTriangle([0, h/2], [w/2, h/2], [0, h], 
        //             corners[3], corners[4], corners[6]);
                    
        // drawTriangle([0, h], [w/2, h/2], [w/2, h], 
        //             corners[6], corners[4], corners[7]);
                    
        // drawTriangle([w/2, h], [w/2, h/2], [w, h], 
        //             corners[7], corners[4], corners[8]);
                    
        // drawTriangle([w, h], [w/2, h/2], [w, h/2], 
        //             corners[8], corners[4], corners[5]);
            // 0 [0, 0],
            // 1 [w/2, 0],
            // 2 [w, 0],
            // 3 [0, h/2],
            // 4 [w/2, h/2],
            // 5 [w, h/2],
            // 6 [0, h],
            // 7 [w/2, h],
            // 8 [w, h],
/*
        drawTriangle([0, 0], [w/2, h/2], [0, h], 
                     corners[0], corners[1], corners[4]);

        drawTriangle([0, 0], [w/2, h/2], [w, 0], 
                     corners[0], corners[2], corners[1]);

        drawTriangle([w, 0], [w/2, h/2], [w, h], 
                     corners[1], corners[2], corners[4]);

        drawTriangle([0, h], [w/2, h/2], [w, h], 
                     corners[3], corners[2], corners[4]);
*/
        // corners.forEach((c, i) => {
        //     const s = handles[i].style;
        //     s.left = c[0] + 'px';
        //     s.top =  c[1] + 'px';
        // });
    }

    img.onload = function()
    {
        const rnd = utils.rndInt;

        w = canv.width = img.width;
        h = canv.height = img.height;

        //Put the four corners (and center) of the source image at semi-random places on the canvas:
        // corners = [[rnd(w*.33),         rnd(h*.33)],
        //            [rnd(w*.33) + w*.67, rnd(h*.33)],
        //            [rnd(w*.33) + w*.33, rnd(h*.33) + h*.33], //center
        //            [rnd(w*.33),         rnd(h*.33) + h*.67],
        //            [rnd(w*.33) + w*.67, rnd(h*.33) + h*.67]];
        // corners = [
        //     [0, 0],           //1
        //     [w/2, 0],         //2
        //     [w, 0],           //3
        //     [0, h/2],         //4
        //     [w/2, h/2],       //5
        //     [w, h/2],         //6
        //     [0, h],           //7
        //     [w/2, h],         //8
        //     [w, h],           //9
        // ];

        updateUI();
        
    function dragTracker({ container, selector, handleOffset = 'center', callback }) {
        const handles = container.querySelectorAll(selector);

        handles.forEach(handle => {
            let offsetX = 0;
            let offsetY = 0;

            handle.addEventListener('mousedown', onMouseDown);

            function onMouseDown(e) {
                //e.preventDefault();

                const rect = handle.getBoundingClientRect();
                offsetX = e.clientX - rect.left;
                offsetY = e.clientY - rect.top;

                if (handleOffset === 'center') {
                    offsetX = rect.width / 2;
                    offsetY = rect.height / 2;
                }

                document.addEventListener('mousemove', onMouseMove);
                document.addEventListener('mouseup', onMouseUp);
            }

            function onMouseMove(e) {
                const parentRect = container.getBoundingClientRect();
                let x = e.clientX - parentRect.left - offsetX;
                let y = e.clientY - parentRect.top - offsetY;

                // Clamp values (optional)
                x = Math.max(0, Math.min(x, parentRect.width - handle.offsetWidth));
                y = Math.max(0, Math.min(y, parentRect.height - handle.offsetHeight));

                handle.style.left = x + 'px';
                handle.style.top = y + 'px';

                const pos = [ x, y ];
                callback(handle, pos);
            }

            function onMouseUp() {
                document.removeEventListener('mousemove', onMouseMove);
                document.removeEventListener('mouseup', onMouseUp);
                //updateUI();
                //console.log("MEMEMME")
            }
        });
    }

    // ✅ Initialize the drag tracker
    dragTracker({
        container: document.querySelector('#drag-wrapper'),
        selector: '.drag-handle',
        handleOffset: 'center',
        callback: (box, pos) => {
            console.log("MOVIN", pos, box.dataset.corner)
            cornersMod[box.dataset.corner] = pos;
            console.log(cornersMod[box.dataset.corner])
            updateUI();
        },
    });
    };

    // const imgW = Math.min(window.innerWidth - 10, 700);
    // img.width = imgW;
    img.src = `https://github.com/dom-github/secretwizardscrolls/blob/main/assets/img/ballad_seven.png?raw=true`;
})();
