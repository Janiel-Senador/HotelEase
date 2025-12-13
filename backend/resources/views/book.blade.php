<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<meta name="csrf-token" content="{{ csrf_token() }}" />
<title>Booking - Hotelbase</title>
<style>
  :root{ --brown:#8B4513;--light-brown:#8B6F47;--muted:#f4f4f6;--card:#fff; --radius:8px;font-family:Arial,Helvetica,sans-serif;color:#333; }
  *{box-sizing:border-box}
  body{margin:0;background:var(--muted);padding:0}
  header{ background:var(--brown); padding:0; margin:0; box-shadow:0 4px 8px rgba(0,0,0,0.1); }
  .nav-indicator{display:none}
  .topbar{ background:var(--brown); padding:14px 0; }
  .topbar .nav-inner{ max-width:1100px; margin:0 auto; display:flex; align-items:center; gap:20px; padding:0 16px; }
  .topbar .brand{ font-weight:700; color:#fff; display:flex; align-items:center; gap:8px; font-size:16px; }
  .brand .logo{ width:22px; height:22px; object-fit:contain }
  .top-links{ margin-left:auto; display:flex; gap:50px; align-items:center; }
  .top-links a{ color:#fff; text-decoration:none; font-size:15px; transition:opacity 0.3s; }
  .top-links a:hover{ opacity:0.8; }
  .top-links a.active{ font-weight:600; background:#6b3410; padding:12px 16px; border-radius:6px; }
  main{ padding:36px 16px; }
  .brand{display:flex;align-items:center;gap:10px;font-weight:700;color:var(--brown)}
  .container{max-width:1100px;margin:0 auto;display:grid;grid-template-columns:1fr 360px;gap:20px}
  .card{background:var(--card);border-radius:var(--radius);padding:22px;box-shadow:0 6px 18px rgba(0,0,0,0.06)}
  .steps{display:flex;gap:10px;margin-bottom:18px}
  .step{flex:1;padding:10px;border-radius:6px;background:#fff;border:1px solid #efefef;font-size:13px;display:flex;align-items:center;gap:10px;transition:transform 250ms, box-shadow 250ms}
  .step.active{background:linear-gradient(90deg,var(--light-brown),var(--brown));color:#fff;border-color:transparent;transform:translateY(-2px);box-shadow:0 6px 16px rgba(0,0,0,0.08)}
  h2{font-size:18px;margin-bottom:12px}
  label{display:block;font-size:13px;margin:8px 0 6px}
  input[type=text], input[type=date], input[type=email], input[type=tel], select, textarea { width:100%;padding:10px;border:1px solid #e2e2e2;border-radius:6px;font-size:14px;background:#fff; }
  .rows{display:grid;grid-template-columns:repeat(2,1fr);gap:12px}
  .rooms-list{display:flex;flex-direction:column;gap:12px;margin-top:12px}
  .room-item{display:flex;gap:12px;align-items:center;padding:10px;border-radius:8px;border:1px solid #eee;transition:border-color 250ms, transform 250ms, box-shadow 250ms}
  .room-item:hover{transform:translateY(-2px);box-shadow:0 6px 16px rgba(0,0,0,0.06)}
  .room-item img{width:84px;height:56px;object-fit:cover;border-radius:6px;background:linear-gradient(135deg,var(--light-brown),#c89b7b)}
  .room-meta{flex:1}
  .room-meta h4{margin:0 0 6px;font-size:15px}
  .room-meta p{margin:0;font-size:13px;color:#666}
  .select-room{background:transparent;border:1px solid var(--brown);color:var(--brown);padding:8px 10px;border-radius:6px;cursor:pointer}
  .summary{position:sticky;top:24px}
  .summary .small{font-size:13px;color:#666;margin-bottom:8px}
  .price{font-weight:700;color:var(--brown);font-size:20px}
  .btn{background:var(--brown);color:#fff;border:none;padding:12px 18px;border-radius:8px;cursor:pointer;font-weight:600;transition:transform 180ms, box-shadow 180ms}
  .btn:hover{transform:translateY(-1px);box-shadow:0 8px 18px rgba(0,0,0,0.08)}
  .btn.secondary{background:#fff;color:var(--brown);border:1px solid #e0d7d0}
  .muted{color:#777;font-size:13px}
  .split{display:flex;gap:10px}
  .hidden{display:none}
  .fade-in{animation:fadeInUp 280ms ease}
  @keyframes fadeInUp{ from{ opacity:0; transform:translateY(8px) } to{ opacity:1; transform:translateY(0) } }
  .info-box{background:#fff8f2;border:1px solid #f0d8c7;padding:10px;border-radius:8px;color:#5a3b23;font-size:14px}
  .copy-btn{background:transparent;border:1px solid var(--brown);color:var(--brown);padding:6px 10px;border-radius:6px;cursor:pointer;font-weight:600}
  @media(max-width:600px){.topbar .nav-inner{padding:0 12px} .top-links a{padding:6px 8px;font-size:13px} .rows{grid-template-columns:1fr}}
</style>
</head>
<body>
<header>
  <div class="nav-indicator" aria-hidden></div>
  <div class="topbar">
    <div class="nav-inner">
      <a href="{{ route('home') }}" style="text-decoration: none;"><div class="brand"><img src="/logo.png" alt="Logo" class="logo"> HotelEase</div></a>
      <nav class="top-links" aria-label="Main">
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('book') }}" class="active">Booking</a>
      </nav>
    </div>
  </div>
</header>

<main class="container">
  <section>
    <div class="card">
      <div class="steps" aria-hidden>
        <div id="stepLabel1" class="step active">1. Dates & Room</div>
        <div id="stepLabel2" class="step">2. Guest Details</div>
        <div id="stepLabel3" class="step">3. Payment</div>
      </div>

      <div id="step1">
        <h2>Step 1: Choose Your Stay Details</h2>
        <div class="rows">
          <div>
            <label for="checkin">Check-in Date</label>
            <input id="checkin" type="date" />
          </div>
          <div>
            <label for="checkout">Check-out Date</label>
            <input id="checkout" type="date" />
          </div>
        </div>

        <div style="margin-top:12px">
          <label for="guests">Number of Guests</label>
          <select id="guests">
            <option>1 Guest</option>
            <option>2 Guests</option>
            <option>3 Guests</option>
            <option>4 Guests</option>
          </select>
        </div>

        <div style="margin-top:14px;display:flex;align-items:center;gap:12px;justify-content:space-between">
          <label style="font-weight:600;margin:0">Available Rooms</label>
          <div class="muted" id="availCount">Showing available rooms</div>
        </div>

        <div class="rooms-list" id="roomsList"></div>

        <div style="display:flex;justify-content:space-between;margin-top:18px">
          <button class="btn secondary" onclick="prevStep()" disabled>Back</button>
          <button class="btn" onclick="nextFromStep1()">Select & Continue</button>
        </div>
      </div>

      <div id="step2" class="hidden">
        <h2>Step 2: Guest Information</h2>
        <div class="rows">
          <div>
            <label for="fullname">Full Name</label>
            <input id="fullname" type="text" placeholder="Enter your full name" oninput="this.value=this.value.replace(/[^A-Za-z\s'\-]/g,'')" />
          </div>
          <div>
            <label for="email">Email Address</label>
            <input id="email" type="email" placeholder="you@mail.com" />
          </div>
        </div>
        <div style="margin-top:12px">
          <label for="phone">Phone Number</label>
          <input id="phone" type="tel" inputmode="numeric" pattern="\d+" placeholder="63+ 998 765 4321" oninput="this.value=this.value.replace(/[^\d]/g,'')" />
        </div>
        <div style="margin-top:12px">
          <label for="requests">Special Requests</label>
          <textarea id="requests" rows="3" placeholder="e.g., late check-in, extra pillows"></textarea>
        </div>
        <div style="display:flex;justify-content:space-between;margin-top:18px">
          <button class="btn secondary" onclick="goTo(1)">Back</button>
          <button class="btn" onclick="validateGuest()">Continue to Payment</button>
        </div>
      </div>

      <div id="step3" class="hidden">
        <h2>Step 3: Secure Payment</h2>
        <label>Payment Method</label>
        <div style="display:flex;gap:10px;margin:8px 0;flex-wrap:wrap">
          <label style="display:flex;align-items:center;gap:8px"><input type="radio" name="pm" value="card" checked /> Credit/Debit Card</label>
          <label style="display:flex;align-items:center;gap:8px"><input type="radio" name="pm" value="arrival" /> Pay on Arrival</label>
          <label style="display:flex;align-items:center;gap:8px"><input type="radio" name="pm" value="ewallet" /> E-Wallet (GCash / PayMaya)</label>
        </div>
        <div id="cardFields">
          <div style="margin-top:8px">
            <label for="cardname">Cardholder Name</label>
            <input id="cardname" type="text" placeholder="Name on card" oninput="this.value=this.value.replace(/[^A-Za-z\s'\-]/g,'')" />
          </div>
          <div class="rows" style="margin-top:8px">
            <div>
              <label for="cardnumber">Card Number</label>
              <input id="cardnumber" type="text" inputmode="numeric" placeholder="1234 5678 9012 3456" maxlength="19" oninput="formatCardNumber(this)" />
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px">
              <input id="expiry" type="text" inputmode="numeric" placeholder="MM/YY" maxlength="5" oninput="formatExpiry(this)" />
              <input id="cvv" type="text" inputmode="numeric" placeholder="CVV" maxlength="4" oninput="this.value=this.value.replace(/[^\d]/g,'')" />
            </div>
          </div>
        </div>
        <div id="ewalletFields" class="hidden" style="margin-top:12px">
          <div class="info-box">
            <strong>Send your e-wallet payment to:</strong>
            <div style="margin-top:8px;display:flex;gap:10px;align-items:center;flex-wrap:wrap">
              <div>
                <div class="muted">Account Name</div>
                <div style="font-weight:700">HotelEase</div>
              </div>
              <div>
                <div class="muted">Mobile / E-Wallet Number</div>
                <div style="font-weight:700" id="ewalletNumber">09978606886</div>
              </div>
              <div>
                <button class="copy-btn" onclick="copyPaymentInfo()">Copy Number</button>
              </div>
            </div>
            <div style="margin-top:8px" class="muted">After sending the payment, please keep the transaction reference and press "Confirm & Book Now". You will receive a confirmation email once the payment is verified.</div>
          </div>
        </div>
        <div style="display:flex;justify-content:space-between;margin-top:18px;align-items:center">
          <button class="btn secondary" onclick="goTo(2)">Back</button>
          <button id="bookNowBtn" class="btn" onclick="confirmBooking()">Confirm & Book Now</button>
        </div>
      </div>
    </div>
  </section>

  <aside class="summary">
    <div class="card">
      <div class="small">Booking Summary</div>
      <div style="display:flex;gap:12px;align-items:center">
        <img id="summaryImage" alt="Room" src="" style="width:84px;height:64px;border-radius:8px;object-fit:cover;background:linear-gradient(135deg,var(--light-brown),#c89b7b)" />
        <div>
          <div id="summaryRoom" style="font-weight:700">—</div>
          <div class="muted" id="summaryDates">Select dates</div>
        </div>
      </div>
      <div style="margin-top:12px">
        <div style="display:flex;justify-content:space-between"><div class="muted">Nights</div><div id="nights">0</div></div>
        <div style="display:flex;justify-content:space-between"><div class="muted">Room Price</div><div id="roomPrice">₱0</div></div>
        <div style="display:flex;justify-content:space-between"><div class="muted">Taxes & Fees</div><div id="taxes">₱0</div></div>
        <hr style="border:none;border-top:1px dashed #eee;margin:12px 0">
        <div style="display:flex;justify-content:space-between"><div style="font-weight:700">Total</div><div class="price" id="total">₱0</div></div>
      </div>
      
    </div>
    <div style="height:14px"></div>
    <div class="card" style="text-align:center">
      <div style="font-weight:700;margin-bottom:8px">Need help?</div>
      <div class="muted">Call: +1 (555) 123-4567<br/>or email: info@hotelease.com</div>
    </div>
  </aside>
</main>

<script type="application/json" id="roomsJson">@json($rooms->map(function($r){ return ['id'=>$r->id,'type'=>$r->type,'price'=>$r->price]; })->values())</script>

<div id="submitOverlay" style="position:fixed;inset:0;background:rgba(0,0,0,0.4);display:none;align-items:center;justify-content:center">
  <div style="background:#fff;border-radius:10px;box-shadow:0 10px 30px rgba(0,0,0,0.2);padding:24px;width:92%;max-width:520px;text-align:center">
    <h2 style="margin:0 0 6px;color:#8B4513">Booking Submitted</h2>
    <div style="color:#666;margin-bottom:16px">Thank You for trusting HotelEase</div>
    <div id="receiptHint" style="color:#666;margin-bottom:12px"></div>
    <div style="display:flex;gap:12px;justify-content:center">
      <a id="homeBtn" class="btn" style="background:#8B4513;color:#fff;padding:10px 16px;border-radius:8px;text-decoration:none" href="{{ route('home') }}">Home</a>
      <a id="receiptBtn" class="btn" style="background:#fff;color:#8B4513;border:1px solid #d6c3b5;padding:10px 16px;border-radius:8px;text-decoration:none" href="#" target="_blank">Check Receipt</a>
    </div>
  </div>
  <style>
    .btn{cursor:pointer}
  </style>
</div>

<div id="paymentConfirm" style="position:fixed;inset:0;background:rgba(0,0,0,0.4);display:none;align-items:center;justify-content:center">
  <div style="background:#fff;border-radius:10px;box-shadow:0 10px 30px rgba(0,0,0,0.2);padding:24px;width:92%;max-width:520px;text-align:center">
    <h2 style="margin:0 0 6px;color:#8B4513">Confirm Payment</h2>
    <div id="paymentConfirmText" style="color:#666;margin-bottom:16px"></div>
    <div style="display:flex;gap:12px;justify-content:center">
      <button id="confirmCancel" class="btn secondary" type="button">Cancel</button>
      <button id="confirmProceed" class="btn" type="button">Confirm</button>
    </div>
  </div>
</div>

<div id="notifyModal" style="position:fixed;inset:0;background:rgba(0,0,0,0.4);display:none;align-items:center;justify-content:center">
  <div style="background:#fff;border-radius:10px;box-shadow:0 10px 30px rgba(0,0,0,0.2);padding:24px;width:92%;max-width:520px;text-align:center">
    <h2 style="margin:0 0 6px;color:#8B4513">Notice</h2>
    <div id="notifyText" style="color:#666;margin-bottom:16px"></div>
    <div style="display:flex;gap:12px;justify-content:center">
      <button id="notifyClose" class="btn secondary" type="button">Close</button>
      <button id="notifyOk" class="btn" type="button">OK</button>
    </div>
  </div>
  <style>.btn{cursor:pointer}</style>
  <script>document.getElementById('notifyClose').onclick=function(){ document.getElementById('notifyModal').style.display='none'; };</script>
</div>

<footer id="contact" style="background-color:#8B6F47;color:white;padding:40px 20px;text-align:center">
  <div class="footer-content" style="max-width:1200px;margin:0 auto;display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:30px;text-align:left">
    <div class="footer-section">
      <h4>🏨 HotelEase</h4>
      <p>Experience comfort and convenience at Hotelbase.</p>
    </div>
    <div class="footer-section">
      <h4>Quick Links</h4>
      <a href="{{ route('home') }}" style="color:#f0f0f0">Home</a>
      <a href="{{ route('services') }}" style="color:#f0f0f0">Services</a>
    </div>
    <div class="footer-section" id="Contact">
      <h4>Contact Info</h4>
      <p>📍 HotelEase, Cebu IT Park, Abad St, Brgy Apas, Cebu City, 6000 Cebu, Philippines.</p>
      <p>📞 +1 (555) 123-4567</p>
      <p>📧 info@hotelease.com</p>
    </div>
    <div class="footer-section">
      <h4>Follow Us</h4>
      <div class="social-icons" style="display:flex;gap:15px;margin-top:15px">
        <a href="#" title="Facebook" style="display:inline-block;width:30px;height:30px;background-color:#6b5a42;border-radius:50%;text-align:center;line-height:30px;color:#fff;text-decoration:none">f</a>
        <a href="#" title="Twitter" style="display:inline-block;width:30px;height:30px;background-color:#6b5a42;border-radius:50%;text-align:center;line-height:30px;color:#fff;text-decoration:none">𝕏</a>
        <a href="#" title="Instagram" style="display:inline-block;width:30px;height:30px;background-color:#6b5a42;border-radius:50%;text-align:center;line-height:30px;color:#fff;text-decoration:none">📷</a>
        <a href="#" title="LinkedIn" style="display:inline-block;width:30px;height:30px;background-color:#6b5a42;border-radius:50%;text-align:center;line-height:30px;color:#fff;text-decoration:none">in</a>
      </div>
    </div>
  </div>
  <div class="footer-bottom" style="margin-top:30px;padding-top:20px;border-top:1px solid rgba(255,255,255,0.2);text-align:center;font-size:12px">
    <p>&copy; 2025 Hotelbase. All rights reserved.</p>
  </div>
</footer>

<script>
const rooms = JSON.parse(document.getElementById('roomsJson').textContent);
const roomInfo = {
  'Standard Room': { desc: 'Comfortable room for 1-2 guests', image: '/StandardRoom.png' },
  'Deluxe Room': { desc: 'Premium furnishings & city view', image: '/Delux.png' },
  'Executive Suite': { desc: 'Separate living area & premium amenities', image: '/Executive.png' },
  'Premium Suite': { desc: 'Panoramic views & exclusive services', image: '/Premium.png' },
  'Family Room': { desc: 'Spacious rooms for families', image: '/Family.png' },
  'Penthouse Suite': { desc: 'Top-floor luxury & concierge', image: '/Penthouse.png' },
};
let state = {step:1,selected: null,checkin:null,checkout:null,guests:1,guestInfo:{},pm:'card'};
let isSubmitting = false;
function $(s){return document.querySelector(s)}
function populateRooms(){ const list = $('#roomsList'); list.innerHTML=''; rooms.forEach(r=>{ const info = roomInfo[r.type] || { desc: '', image: '/StandardRoom.png' }; const div = document.createElement('div'); div.className='room-item'; div.innerHTML = `<img alt="${r.type}" src="${info.image}" /><div class=\"room-meta\"><h4>${r.type}</h4><p>${info.desc}</p></div>
      <div style=\"text-align:right\"><div class=\"muted\">₱${r.price}/night</div>
      <div style=\"margin-top:8px\"><button class=\"select-room\" data-id=\"${r.id}\" data-label=\"${r.type}\" data-type=\"${r.type}\" data-price=\"${r.price}\">Select</button></div></div>`; list.appendChild(div); }); list.querySelectorAll('.select-room').forEach(btn=>{ btn.addEventListener('click',()=> { const id=+btn.dataset.id; const price=+btn.dataset.price; const label=btn.dataset.label; const type=btn.dataset.type; selectRoom({id,price,label,type}); }); }); }
function selectRoom(sel){ const info = roomInfo[sel.type] || { image: '/StandardRoom.png' }; state.selected={id:sel.id,label:sel.label,price:sel.price,type:sel.type,image:info.image}; $('#summaryRoom').textContent = sel.label; $('#summaryImage').src = state.selected.image; updateSummary(); document.querySelectorAll('.room-item').forEach(it => it.style.borderColor='#eee'); const btn = document.querySelector(`.select-room[data-id="${sel.id}"]`); if(btn){ const card = btn.closest('.room-item'); card.style.borderColor='rgba(139,69,19,0.9)'; card.classList.remove('fade-in'); void card.offsetWidth; card.classList.add('fade-in'); } updateProceedButtonState(); }
function nightsBetween(ci,co){ if(!ci||!co) return 0; const a=new Date(ci), b=new Date(co); const diff=(b-a)/(1000*60*60*24); return diff>0?diff:0; }
function updateSummary(){ const nights = nightsBetween(state.checkin,state.checkout); $('#nights').textContent = nights; const price = state.selected ? state.selected.price : 0; $('#roomPrice').textContent = `₱${price}/night`; const subtotal = nights * price; const taxes = Math.round(subtotal * 0.12); $('#taxes').textContent = `₱${taxes}`; $('#total').textContent = `₱${(subtotal + taxes).toLocaleString()}`; $('#summaryDates').textContent = state.checkin && state.checkout ? `${state.checkin} → ${state.checkout}` : 'Select dates'; updateProceedButtonState(); }
function canProceedToPayment(){ const ci = $('#checkin').value, co = $('#checkout').value; if(!ci || !co) return false; if(nightsBetween(ci,co) <= 0) return false; if(!state.selected) return false; const name = $('#fullname').value ? $('#fullname').value.trim() : ''; const email = $('#email').value ? $('#email').value.trim() : ''; if(!name || !email) return false; return true; }
function updateProceedButtonState(){ const btn = $('#proceedBtn'); if(!btn) return; if(canProceedToPayment()){ btn.disabled = false; btn.title = "Proceed to payment"; btn.style.opacity = '1'; btn.style.cursor = 'pointer'; } else { btn.disabled = true; btn.title = "Complete steps 1 & 2 to proceed"; btn.style.opacity = '0.7'; btn.style.cursor = 'not-allowed'; } }
function goTo(n){ state.step = n; $('#step1').classList.toggle('hidden', n!==1); $('#step2').classList.toggle('hidden', n!==2); $('#step3').classList.toggle('hidden', n!==3); const activeId = n===1?'#step1':n===2?'#step2':'#step3'; const el = document.querySelector(activeId); if(el){ el.classList.remove('fade-in'); void el.offsetWidth; el.classList.add('fade-in'); } $('#stepLabel1').classList.toggle('active', n===1); $('#stepLabel2').classList.toggle('active', n===2); $('#stepLabel3').classList.toggle('active', n===3); window.scrollTo({top:0,behavior:'smooth'}); }
function prevStep(){ if(state.step>1) goTo(state.step-1) }
function nextFromStep1(){ const ci = $('#checkin').value, co = $('#checkout').value; if(!ci||!co){alert('Please choose check-in and check-out dates.');return} if(nightsBetween(ci,co)<=0){alert('Check-out must be after check-in.');return} if(!state.selected){alert('Please select a room from the available rooms.');return} state.checkin=ci; state.checkout=co; state.guests = $('#guests').value; updateSummary(); goTo(2); }
function openNotify(msg, onOk){ const m=document.getElementById('notifyModal'); document.getElementById('notifyText').textContent=msg; m.style.display='flex'; var ok=document.getElementById('notifyOk'); ok.onclick=function(){ m.style.display='none'; if(typeof onOk==='function'){ onOk(); } } }
function validateGuest(){ const name=$('#fullname').value.trim(), email=$('#email').value.trim(), phone=$('#phone').value.trim(); if(!name||!email){ document.getElementById('guests').value='1 Guest'; state.guests='1 Guest'; updateProceedButtonState(); openNotify('Please enter name and email.', null); return } if(!email.includes('@')){ document.getElementById('guests').value='1 Guest'; state.guests='1 Guest'; updateProceedButtonState(); openNotify('Email must contain @', null); return } state.guestInfo={name,email,phone,requests:$('#requests').value.trim()}; openNotify('Proceed to payment?', function(){ goTo(3); }); }
function proceedToPayment(){ const ci = $('#checkin').value, co = $('#checkout').value; if(!ci || !co){ alert('Please choose check-in and check-out dates before proceeding.'); goTo(1); return; } if(nightsBetween(ci,co) <= 0){ alert('Check-out must be after check-in.'); goTo(1); return; } if(!state.selected){ alert('Please select a room from the available rooms before proceeding.'); goTo(1); return; } const name = $('#fullname').value ? $('#fullname').value.trim() : ''; const email = $('#email').value ? $('#email').value.trim() : ''; if(!name || !email){ alert('Please enter guest name and email before proceeding to payment.'); goTo(2); return; } state.checkin = ci; state.checkout = co; state.guests = $('#guests').value; state.guestInfo = { name, email, phone: ($('#phone').value||'').trim(), requests: ($('#requests').value||'').trim() }; updateSummary(); goTo(3); }
function copyPaymentInfo(){ const num = document.getElementById('ewalletNumber').textContent.trim(); if(!navigator.clipboard){ const ta = document.createElement('textarea'); ta.value = num; document.body.appendChild(ta); ta.select(); try{ document.execCommand('copy'); alert('Number copied to clipboard'); } catch(e){ alert('Copy failed. Number: ' + num); } document.body.removeChild(ta); return; } navigator.clipboard.writeText(num).then(()=>alert('E-wallet number copied to clipboard'), ()=>alert('Could not copy. Number: ' + num)); }
function formatCardNumber(el){ const v = el.value.replace(/\D/g,'').slice(0,16); const parts = v.match(/.{1,4}/g); el.value = parts ? parts.join(' ') : v; }
function formatExpiry(el){ let v = el.value.replace(/[^0-9]/g,'').slice(0,4); if(v.length>=2){ let m = v.slice(0,2); let mi = parseInt(m,10); if(mi<1) m='01'; if(mi>12) m='12'; const y = v.slice(2); el.value = y ? m + '/' + y : m; } else { el.value = v; } }
function submitBooking(){
  if(isSubmitting) return;
  isSubmitting = true;
  const confirmBtn = document.getElementById('confirmProceed');
  const bookBtn = document.getElementById('bookNowBtn');
  if(confirmBtn) confirmBtn.disabled = true;
  if(bookBtn) bookBtn.disabled = true;
  const fd = new FormData();
  fd.append('room_id', state.selected?.id||'');
  fd.append('guest_name', $('#fullname').value.trim());
  fd.append('guest_email', $('#email').value.trim());
  fd.append('check_in_date', $('#checkin').value);
  fd.append('check_out_date', $('#checkout').value);
  fd.append('payment_method', state.pm);
  fd.append('notes', ($('#requests').value||'').trim());
  const token = document.querySelector('meta[name=csrf-token]').getAttribute('content');
  fetch("{{ route('book-now') }}", { method: 'POST', headers: { 'X-CSRF-TOKEN': token }, body: fd })
    .then(r => { if(!r.ok) throw new Error('Failed'); return r.json(); })
    .then(data => {
      document.getElementById('paymentConfirm').style.display = 'none';
      const overlay = document.getElementById('submitOverlay');
      const receiptBtn = document.getElementById('receiptBtn');
      const hint = document.getElementById('receiptHint');
      receiptBtn.href = "{{ url('/receipt') }}" + "/" + data.id;
      hint.textContent = `Receipt #${data.id}`;
      overlay.style.display = 'flex';
      setTimeout(() => { window.location.href = "{{ route('home') }}"; }, 6000);
    })
    .catch(() => { alert('Could not submit booking'); if(confirmBtn) confirmBtn.disabled = false; if(bookBtn) bookBtn.disabled = false; isSubmitting = false; });
}
function openPaymentConfirm(){
  const modal = document.getElementById('paymentConfirm');
  const text = document.getElementById('paymentConfirmText');
  if(state.pm === 'card'){
    text.textContent = 'Proceed with Credit/Debit Card payment?';
  } else if(state.pm === 'ewallet'){
    text.textContent = 'Confirm you have sent the E-Wallet payment and proceed?';
  } else {
    text.textContent = 'Proceed with Pay on Arrival?';
  }
  modal.style.display = 'flex';
  document.getElementById('confirmCancel').onclick = function(){ modal.style.display = 'none'; };
  document.getElementById('confirmProceed').onclick = function(){ submitBooking(); };
}
function confirmBooking(){
  // Basic client-side checks remain, but no alerts for card/ewallet
  if(state.pm==='card'){
    openPaymentConfirm();
    return;
  }
  if(state.pm==='ewallet'){
    openPaymentConfirm();
    return;
  }
  submitBooking();
}
function initFromQuery(){ const qp = new URLSearchParams(location.search); const pre = qp.get('room'); populateRooms(); if(pre){ const match = rooms.find(r=> String(r.type).toLowerCase() === String(pre).toLowerCase()); if(match){ selectRoom({id:match.id, price:match.price, label:match.type, type:match.type}); } } $('#checkin').addEventListener('change', e => { state.checkin = e.target.value; updateSummary(); }); $('#checkout').addEventListener('change', e => { state.checkout = e.target.value; updateSummary(); }); $('#guests').addEventListener('change', e => { state.guests = e.target.value; updateProceedButtonState(); }); ['#fullname','#email','#phone','#requests'].forEach(sel=>{ const el = document.querySelector(sel); if(el) el.addEventListener('input', updateProceedButtonState); }); updateSummary(); updateProceedButtonState(); }
document.addEventListener('change', e=>{ if(e.target.name==='pm'){ state.pm=e.target.value; document.getElementById('cardFields').style.display = state.pm==='card' ? 'block' : 'none'; document.getElementById('ewalletFields').style.display = state.pm==='ewallet' ? 'block' : 'none'; } updateProceedButtonState(); });
initFromQuery();
</script>
</body>
</html>
