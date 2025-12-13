<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Room Management</title>
    <style>
        *{box-sizing:border-box}
        :root{ --primary:#11998e; --secondary:#38ef7d; --white:#fff; --gray:#9b9b9b }
        html, body { scroll-behavior: smooth; }
        html { overflow-x:hidden }
        body{margin:0;font-family:Inter,Arial,Helvetica,sans-serif;color:#e5e7eb;background:hsl(275, 53%, 3%); overflow-x:hidden}
        #dst { position: fixed; inset: 0; width:100%; height:100%; z-index:0; pointer-events:none; display:block }
        .topbar { display:flex; align-items:center; justify-content:space-between; padding:16px 24px; position:sticky; top:0; z-index:2; backdrop-filter: blur(10px); background: rgba(255,255,255,0.06); border-bottom: 1px solid rgba(255,255,255,0.08); }
        .brand { display:flex; align-items:center; gap:8px; font-weight:700; color:#fff; }
        .brand .logo{ width:24px; height:24px; object-fit:contain }
        .nav-buttons { display:flex; gap:12px; }
        .glass-btn { padding:10px 14px; border-radius:12px; backdrop-filter: blur(10px); background: rgba(255,255,255,0.08); color:#fff; border:1px solid rgba(255,255,255,0.12); cursor:pointer; font-weight:600; }
        .glass-btn:hover { background: rgba(255,255,255,0.14); }
        .main{max-width:1100px;margin:24px auto;padding:0 16px;position:relative;z-index:1}
        .card{background: rgba(17,24,39,0.7); border:1px solid rgba(255,255,255,0.08); border-radius:14px; padding:20px; box-shadow:0 20px 40px rgba(0,0,0,0.35)}
        .card-title{font-size:20px;font-weight:700;margin-bottom:16px;color:#e5e7eb}
        .table-header{display:grid;grid-template-columns:0.9fr 1.6fr 0.9fr 1.5fr 1fr 0.9fr;gap:12px;padding:12px 0;border-bottom:2px solid rgba(255,255,255,0.12);font-size:13px;color:#94a3b8;font-weight:600}
        .row{display:grid;grid-template-columns:0.9fr 1.6fr 0.9fr 1.5fr 1fr 0.9fr;gap:12px;padding:14px;margin:8px 0;align-items:center;background:rgba(17,24,39,0.65);border:1px solid rgba(255,255,255,0.10);border-radius:12px;backdrop-filter:blur(12px)}
        input,select{width:100%;padding:10px;border:1px solid rgba(255,255,255,0.15);border-radius:12px;font-size:13px;background:rgba(255,255,255,0.08);color:#fff;backdrop-filter:blur(8px)}
        .select-glass { appearance:none;background: rgba(255,255,255,0.08); color:#fff; border:1px solid rgba(255,255,255,0.15); border-radius:12px; padding:10px 12px; backdrop-filter: blur(10px); }
        .select-glass option{background:#0b1220;color:#fff}
        .actions{display:flex;justify-content:center;align-items:center;gap:8px}
        .btn.save{min-width:110px}
        .btn{padding:10px 12px;border:none;border-radius:10px;cursor:pointer;font-size:13px}
        .btn.save{background:#27ae60;color:#fff}
        .btn.cancel{background:#e74c3c;color:#fff}
        .muted{color:#94a3b8;font-size:12px}
        .toast{position:fixed; top:16px; right:16px; z-index:3; background:rgba(17,24,39,0.85); color:#fff; padding:10px 14px; border-radius:10px; border:1px solid rgba(255,255,255,0.12); backdrop-filter:blur(8px); opacity:0; transform:translateY(-8px); transition: opacity .3s ease, transform .3s ease}
        .toast.show{opacity:1; transform:translateY(0)}
</style>
</head>
<body>
<canvas id="dst"></canvas>
<div class="topbar">
    <a class="glass-btn" href="{{ route('admin') }}#dashboard" style="margin-left:auto">Return</a>
</div>
@if(session('status'))
    <div class="toast" id="toast">{{ session('status') }}</div>
@endif
<div class="main">
    <div class="card">
        <div class="card-title">Room Management</div>
        <div class="table-header">
            <div>Room</div>
            <div>Type</div>
            <div>Status</div>
            <div>Guest</div>
            <div>Check-out</div>
            <div>Actions</div>
        </div>
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px">
            <label style="display:flex; align-items:center; gap:8px"><input type="checkbox" id="selectAll"> <span>Select all</span></label>
            <button class="btn cancel" type="button" id="bulkDeleteBtn">Delete Selected</button>
        </div>
        @forelse($bookings as $b)
            <form class="row" method="POST" action="{{ route('admin.booking.update', $b) }}" data-booking-id="{{ $b->id }}">
                @csrf
                <div style="display:flex; align-items:center; gap:8px"><input type="checkbox" class="bulk-select" data-id="{{ $b->id }}"><span>{{ optional($b->room)->number }}</span></div>
                <div>
                    <select name="room_type" class="select-glass">
                        @php($types=['Standard Room','Deluxe Room','Executive Suite','Premium Suite','Family Room','Penthouse Suite'])
                        @foreach($types as $t)
                            <option value="{{ $t }}" @selected(optional($b->room)->type === $t)>{{ $t }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <select name="status" class="select-glass">
                        @php($statuses=['pending','confirmed','cancelled','checked_in','checked_out'])
                        @foreach($statuses as $s)
                            <option value="{{ $s }}" @selected($b->status === $s)>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <input type="text" name="guest_name" value="{{ $b->guest_name }}" />
                </div>
                <div>
                    <input type="date" name="check_out_date" value="{{ $b->check_out_date }}" />
                </div>
                <div class="actions">
                    <button class="btn save" type="submit">Save</button>
                </div>
            </form>
        @empty
            <div class="muted" style="padding:12px">No bookings to manage.</div>
        @endforelse
    </div>
</div>
<script>
    (function(){
        var canvas=document.getElementById('dst');
        var ctx=canvas.getContext('2d'); if(!ctx){return}
        var dpr=window.devicePixelRatio||1; var W=0,H=0; var particles=[],icons=[],ribbons=[]; var scrollPos=0;
        function resize(){ W=canvas.width=Math.ceil(window.innerWidth*dpr); H=canvas.height=Math.ceil(window.innerHeight*dpr); canvas.style.width=window.innerWidth+'px'; canvas.style.height=window.innerHeight+'px'; initScene(); }
        function initScene(){ particles=[]; icons=[]; ribbons=[]; for(var i=0;i<50;i++){ particles.push({x:Math.random()*W,y:Math.random()*H,r:(Math.random()*2+0.6)*dpr,s:0.12+Math.random()*0.5}); }
            var seg=5; var sw=W/seg; var baseY=H*0.58; var types=['bell','key','calendar','bed','receipt'];
            for(var k=0;k<seg;k++){ var cx=k*sw+sw*0.5; var cy=baseY+(Math.random()*H*0.06-H*0.03); var sz=(28+Math.random()*18)*dpr; icons.push({type:types[k%types.length],x:cx,y:cy,size:sz,phase:Math.random()*Math.PI*2,speed:0.3+Math.random()*0.25,ax:8*dpr,ay:6*dpr}); }
            for(var j=0;j<4;j++){ var yb=H*(0.32+0.18*j); ribbons.push({y:yb,amp1:10*dpr,amp2:5*dpr,offset:Math.random()*Math.PI*2,width:2*dpr}); }
        }
        function drawBackground(t){ var yCenter = H*0.2 - (scrollPos*dpr*0.03); var g=ctx.createLinearGradient(0,0,0,H); g.addColorStop(0,'#1a1233'); g.addColorStop(1,'#23153c'); ctx.fillStyle=g; ctx.fillRect(0,0,W,H);
            var rg=ctx.createRadialGradient(W*0.5,yCenter,H*0.06,W*0.5,H*0.5,H*0.85); rg.addColorStop(0,'rgba(247,181,0,0.10)'); rg.addColorStop(1,'rgba(247,181,0,0.0)'); ctx.fillStyle=rg; ctx.fillRect(0,0,W,H); }
        function drawRibbons(t){ for(var i=0;i<ribbons.length;i++){ var rb=ribbons[i]; ctx.lineWidth=rb.width; ctx.shadowColor='rgba(247,181,0,0.5)'; ctx.shadowBlur=10*dpr; ctx.strokeStyle='rgba(247,181,0,0.18)'; ctx.beginPath(); var baseY = rb.y - scrollPos*dpr*0.06; ctx.moveTo(0,baseY);
            for(var x=0;x<=W;x+=8*dpr){ var y=baseY+rb.amp1*Math.sin(x*0.006+t*0.6+rb.offset)+rb.amp2*Math.sin(x*0.013-t*0.4); ctx.lineTo(x,y); } ctx.stroke(); ctx.shadowBlur=0; } }
        function drawIconShape(type,s){ if(type==='bell'){ ctx.beginPath(); ctx.arc(0,-s*0.08,s*0.22,0,Math.PI*2); ctx.fill(); ctx.fillRect(-s*0.30,-s*0.02,s*0.60,s*0.40); ctx.beginPath(); ctx.arc(0,-s*0.32,s*0.06,0,Math.PI*2); ctx.fill(); }
            else if(type==='key'){ ctx.beginPath(); ctx.arc(-s*0.20,-s*0.08,s*0.16,0,Math.PI*2); ctx.fill(); ctx.fillRect(-s*0.04,-s*0.10,s*0.46,s*0.12); ctx.fillRect(s*0.30,-s*0.10,s*0.10,s*0.12); }
            else if(type==='calendar'){ ctx.fillRect(-s*0.32,-s*0.28,s*0.64,s*0.54); ctx.clearRect(-s*0.32,-s*0.28,s*0.64,s*0.14); ctx.fillRect(-s*0.32,-s*0.28,s*0.64,s*0.10); }
            else if(type==='bed'){ ctx.fillRect(-s*0.34,-s*0.06,s*0.68,s*0.24); ctx.beginPath(); ctx.arc(-s*0.28,-s*0.12,s*0.10,0,Math.PI*2); ctx.fill(); }
            else { ctx.fillRect(-s*0.28,-s*0.16,s*0.56,s*0.34); ctx.clearRect(-s*0.24,-s*0.12,s*0.48,s*0.10); } }
        function drawIcons(t){ for(var i=0;i<icons.length;i++){ var ic=icons[i]; var x=ic.x+Math.sin(t*ic.speed+ic.phase)*ic.ax; var y=ic.y - scrollPos*dpr*0.10 + Math.cos(t*ic.speed*0.8+ic.phase)*ic.ay; var s=ic.size*(0.98+0.02*Math.sin(t*0.9+ic.phase)); ctx.save(); ctx.translate(x,y); ctx.fillStyle='rgba(247,181,0,0.85)'; ctx.shadowColor='#f7b500'; ctx.shadowBlur=14*dpr; drawIconShape(ic.type,s); ctx.restore(); } ctx.shadowBlur=0; }
        function drawParticles(){ for(var i=0;i<particles.length;i++){ var p=particles[i]; ctx.fillStyle='rgba(247,181,0,0.12)'; ctx.beginPath(); ctx.arc(p.x,p.y - scrollPos*dpr*0.02,p.r,0,Math.PI*2); ctx.fill(); p.y-=p.s; if(p.y<-10) p.y=H+10; } }
        function render(){ var t=performance.now()/1000; drawBackground(t); drawRibbons(t); drawIcons(t); drawParticles(); requestAnimationFrame(render); }
        window.addEventListener('resize',resize); window.addEventListener('scroll',function(){ scrollPos=(window.scrollY||0) }); resize(); render();
    })();
    (function(){
        var t = document.getElementById('toast');
        if(t){
            // show immediately
            requestAnimationFrame(function(){ t.classList.add('show'); });
            // hide after 2s, then remove
            setTimeout(function(){ t.classList.remove('show'); }, 2000);
            setTimeout(function(){ if(t && t.parentNode){ t.parentNode.removeChild(t); } }, 2400);
        }
    })();
    (function(){
        var selectAll=document.getElementById('selectAll'); var checks=[].slice.call(document.querySelectorAll('.bulk-select'));
        if(selectAll){ selectAll.addEventListener('change', function(){ checks.forEach(function(c){ c.checked = selectAll.checked; }); }); }
        var btn=document.getElementById('bulkDeleteBtn'); var csrf='{{ csrf_token() }}';
        function deleteOne(id){ return fetch('/admin/bookings/'+id+'/delete', { method:'POST', headers:{'X-CSRF-TOKEN':csrf}, body:new URLSearchParams() }); }
        var pendingIds=[];
        function getModalEls(){ return { modal:document.getElementById('bulkConfirmModal'), text:document.getElementById('bulkConfirmText'), cancelBtn:document.getElementById('bulkConfirmCancel'), okBtn:document.getElementById('bulkConfirmProceed') }; }
        function openModal(msg, ids){ var els=getModalEls(); pendingIds = ids || []; if(!els.modal||!els.text) return; els.text.textContent = msg; els.modal.style.display='flex'; if(els.cancelBtn){ els.cancelBtn.onclick=function(){ closeModal(); }; } if(els.okBtn){ els.okBtn.onclick = async function(){ if(!pendingIds.length){ closeModal(); return; } els.okBtn.disabled=true; if(els.cancelBtn) els.cancelBtn.disabled=true; for(var i=0;i<pendingIds.length;i++){ await deleteOne(pendingIds[i]); } location.reload(); }; } }
        function closeModal(){ var els=getModalEls(); if(els.modal){ els.modal.style.display='none'; } pendingIds=[]; }
        if(btn){ btn.addEventListener('click', function(){ var ids=checks.filter(function(c){return c.checked}).map(function(c){return c.getAttribute('data-id')}); if(!ids.length){ openModal('Select at least one booking to delete.', []); return; } openModal('Delete selected bookings?', ids); }); }
    })();
</script>
<div id="bulkConfirmModal" style="position:fixed;inset:0;background:rgba(0,0,0,0.4);display:none;align-items:center;justify-content:center">
  <div style="background:#fff;border-radius:10px;box-shadow:0 10px 30px rgba(0,0,0,0.2);padding:24px;width:92%;max-width:520px;text-align:center">
    <h2 style="margin:0 0 6px;color:#8B4513">Confirm Deletion</h2>
    <div id="bulkConfirmText" style="color:#666;margin-bottom:16px"></div>
    <div style="display:flex;gap:12px;justify-content:center">
      <button id="bulkConfirmCancel" class="btn cancel" type="button">Cancel</button>
      <button id="bulkConfirmProceed" class="btn save" type="button">Confirm</button>
    </div>
  </div>
</div>
</body>
</html>
