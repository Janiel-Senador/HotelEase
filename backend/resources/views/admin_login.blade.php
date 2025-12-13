<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Admin Login</title>
    <style>
        :root{ --accent:#8B4513 }
        *{ box-sizing:border-box }
        html, body{ margin:0; padding:0; overflow:hidden; background:#000 }
        canvas{ display:block; position:fixed; inset:0; width:100vw; height:100vh; z-index:0 }
        .modal-wrap{ min-height:100vh; display:flex; align-items:center; justify-content:center; padding:24px; position:relative; z-index:1 }
        .modal{ width:92%; max-width:420px; border-radius:16px; background:rgba(17,24,39,0.6); border:1px solid rgba(255,255,255,0.14); box-shadow:0 20px 40px rgba(0,0,0,0.45); padding:24px; color:#fff; backdrop-filter:blur(16px) saturate(160%); -webkit-backdrop-filter:blur(16px) saturate(160%) }
        .brand{ display:flex; align-items:center; justify-content:center; gap:8px; font-weight:700; color:#fff; margin-bottom:8px }
        .brand .logo{ width:24px; height:24px; object-fit:contain }
        h1{ font-size:20px; margin:0 0 14px; text-align:center; color:#fff }
        label{ display:block; font-size:13px; margin:8px 0 6px; color:#ddd }
        .pw-wrap{ position:relative }
        input{ width:100%; padding:12px; border:1px solid rgba(255,255,255,0.22); border-radius:14px; font-size:14px; background:rgba(255,255,255,0.08); color:#fff; backdrop-filter:blur(14px) saturate(160%); -webkit-backdrop-filter:blur(14px) saturate(160%) }
        input:focus{ outline:none; border-color: rgba(255,255,255,0.45); background: rgba(255,255,255,0.12) }
        .eye-btn{ position:absolute; right:12px; top:50%; transform:translateY(-50%); background:transparent; border:none; color:#fff; opacity:.7; cursor:pointer; font-size:16px; line-height:1 }
        .eye-btn:hover{ opacity:1 }
        .btn{ background:rgba(255,255,255,0.12); color:#fff; border:1px solid rgba(255,255,255,0.24); padding:12px 18px; border-radius:14px; cursor:pointer; font-weight:600; width:100%; backdrop-filter:blur(14px) saturate(160%); -webkit-backdrop-filter:blur(14px) saturate(160%) }
        .btn:hover{ background:rgba(255,255,255,0.18) }
        .error{ color:#ffd0c7; font-size:13px; text-align:center; margin-top:10px }
        
    </style>
    </head>
    <body>
        <canvas id="glcanvas"></canvas>
        <div class="modal-wrap">
            <div class="modal">
                <div class="brand"><img src="/logo.png" alt="Logo" class="logo"> HotelEase</div>
                <h1>Admin Login</h1>
                <form method="POST" action="{{ route('admin.login.post') }}">
                    @csrf
                    <label for="username">Username or Email</label>
                    <input id="username" name="username" type="text" value="{{ old('username') }}" placeholder="Enter username or email" required />
                    <label for="password">Password</label>
                    <div class="pw-wrap">
                        <input id="password" name="password" type="password" placeholder="Enter password" required />
                        <button type="button" id="togglePassword" class="eye-btn" aria-label="Toggle password">👁</button>
                    </div>
                    <div style="margin-top:14px"><button class="btn" type="submit">Sign in</button></div>
                    @if($errors->any())
                        <div class="error">{{ $errors->first() }}</div>
                    @endif
                </form>
            </div>
            
        </div>
        <script>
        (function(){
            var canvas=document.getElementById('glcanvas');
            var ctx=canvas.getContext('2d');
            if(!ctx){return}
            var dpr=window.devicePixelRatio||1;
            var W=0,H=0;
            var particles=[];
            var icons=[];
            var ribbons=[];
            var groundH=0;
            function resize(){
                W=canvas.width=Math.ceil(window.innerWidth*dpr);
                H=canvas.height=Math.ceil(window.innerHeight*dpr);
                canvas.style.width=window.innerWidth+'px';
                canvas.style.height=window.innerHeight+'px';
                groundH=0;
                initScene();
            }
            function initScene(){
                particles=[]; icons=[]; ribbons=[];
                for(var i=0;i<60;i++){
                    particles.push({x:Math.random()*W,y:Math.random()*H,r:(Math.random()*2+0.6)*dpr,s:0.12+Math.random()*0.5});
                }
                var seg=5; var sw=W/seg; var baseY=H*0.58;
                var types=['bell','key','calendar','bed','receipt'];
                for(var k=0;k<seg;k++){
                    var cx=k*sw+sw*0.5;
                    var cy=baseY+(Math.random()*H*0.06-H*0.03);
                    var sz=(36+Math.random()*18)*dpr;
                    icons.push({type:types[k%types.length],x:cx,y:cy,size:sz,phase:Math.random()*Math.PI*2,speed:0.3+Math.random()*0.25,ax:10*dpr,ay:8*dpr});
                }
                for(var j=0;j<4;j++){
                    var yb=H*(0.32+0.18*j);
                    ribbons.push({y:yb,amp1:10*dpr,amp2:5*dpr,offset:Math.random()*Math.PI*2,width:2*dpr});
                }
            }

            
            
            function drawBackground(t){
                var g=ctx.createLinearGradient(0,0,0,H);
                g.addColorStop(0,'#1a1233');
                g.addColorStop(1,'#23153c');
                ctx.fillStyle=g; ctx.fillRect(0,0,W,H);
                var rg=ctx.createRadialGradient(W*0.5,H*0.2,H*0.06,W*0.5,H*0.5,H*0.85);
                rg.addColorStop(0,'rgba(247,181,0,0.10)');
                rg.addColorStop(1,'rgba(247,181,0,0.0)');
                ctx.fillStyle=rg; ctx.fillRect(0,0,W,H);
                if(groundH>0){ var gg=ctx.createLinearGradient(0,H-groundH,0,H); gg.addColorStop(0,'#1b1236'); gg.addColorStop(1,'#120c26'); ctx.fillStyle=gg; ctx.fillRect(0,H-groundH,W,groundH); }
            }

            function drawRibbons(t){
                for(var i=0;i<ribbons.length;i++){
                    var rb=ribbons[i];
                    ctx.lineWidth=rb.width;
                    ctx.shadowColor='rgba(247,181,0,0.5)';
                    ctx.shadowBlur=10*dpr;
                    ctx.strokeStyle='rgba(247,181,0,0.18)';
                    ctx.beginPath();
                    ctx.moveTo(0,rb.y);
                    for(var x=0;x<=W;x+=8*dpr){
                        var y=rb.y+rb.amp1*Math.sin(x*0.006+t*0.6+rb.offset)+rb.amp2*Math.sin(x*0.013-t*0.4);
                        ctx.lineTo(x,y);
                    }
                    ctx.stroke();
                    ctx.shadowBlur=0;
                }
            }

            function drawIconShape(type,s){
                if(type==='bell'){
                    ctx.beginPath(); ctx.arc(0,-s*0.08,s*0.22,0,Math.PI*2); ctx.fill();
                    ctx.fillRect(-s*0.30,-s*0.02,s*0.60,s*0.40);
                    ctx.beginPath(); ctx.arc(0,-s*0.32,s*0.06,0,Math.PI*2); ctx.fill();
                } else if(type==='key'){
                    ctx.beginPath(); ctx.arc(-s*0.20,-s*0.08,s*0.16,0,Math.PI*2); ctx.fill();
                    ctx.fillRect(-s*0.04,-s*0.10,s*0.46,s*0.12);
                    ctx.fillRect(s*0.30,-s*0.10,s*0.10,s*0.12);
                } else if(type==='calendar'){
                    ctx.fillRect(-s*0.32,-s*0.28,s*0.64,s*0.54);
                    ctx.clearRect(-s*0.32,-s*0.28,s*0.64,s*0.14);
                    ctx.fillRect(-s*0.32,-s*0.28,s*0.64,s*0.10);
                } else if(type==='bed'){
                    ctx.fillRect(-s*0.34,-s*0.06,s*0.68,s*0.24);
                    ctx.beginPath(); ctx.arc(-s*0.28,-s*0.12,s*0.10,0,Math.PI*2); ctx.fill();
                } else {
                    ctx.fillRect(-s*0.28,-s*0.16,s*0.56,s*0.34);
                    ctx.clearRect(-s*0.24,-s*0.12,s*0.48,s*0.10);
                }
            }

            function drawIcons(t){
                for(var i=0;i<icons.length;i++){
                    var ic=icons[i];
                    var x=ic.x+Math.sin(t*ic.speed+ic.phase)*ic.ax;
                    var y=ic.y+Math.cos(t*ic.speed*0.8+ic.phase)*ic.ay;
                    var s=ic.size*(0.98+0.02*Math.sin(t*0.9+ic.phase));
                    ctx.save();
                    ctx.translate(x,y);
                    ctx.fillStyle='rgba(247,181,0,0.85)';
                    ctx.shadowColor='#f7b500';
                    ctx.shadowBlur=14*dpr;
                    drawIconShape(ic.type,s);
                    ctx.restore();
                }
                ctx.shadowBlur=0;
            }
            
            
            function drawParticles(){
                for(var i=0;i<particles.length;i++){
                    var p=particles[i];
                    ctx.fillStyle='rgba(247,181,0,0.12)';
                    ctx.beginPath(); ctx.arc(p.x,p.y,p.r,0,Math.PI*2); ctx.fill();
                    p.y-=p.s; if(p.y<-10) p.y=H+10;
                }
            }
            function render(){
                var t=performance.now()/1000;
                drawBackground(t);
                drawRibbons(t);
                drawIcons(t);
                drawParticles();
                requestAnimationFrame(render);
            }
            window.addEventListener('resize',resize);
            resize();
            render();
        })();
        </script>
        <script>
        (function(){
            var btn = document.getElementById('togglePassword');
            var input = document.getElementById('password');
            if(btn && input){
                btn.addEventListener('click', function(){
                    var show = input.type === 'password';
                    input.type = show ? 'text' : 'password';
                    btn.textContent = show ? '🙈' : '👁';
                });
            }
        })();
        </script>
    </body>
</html>
