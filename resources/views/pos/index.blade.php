<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Kasir - Donik Donuts</title>
<link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
<link rel="shortcut icon" href="{{ asset('favicon.svg') }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{
  --ink:#1c1c1e;--ink2:#3a3a3c;--ink3:#636366;--dim:#aeaeb2;
  --line:#e5e5ea;--bg:#f2f2f7;--white:#fff;
  --tea:#3d6b4f;--tea-d:#2f5440;--tea-l:#eaf4ee;--tea-p:#f4faf6;
  --red:#c0392b;
  --topbar:#1c1c1e;--cats:#1c1f1e;
}

/* ── DARK MODE ── */
[data-theme="dark"]{
  --ink:#f2f2f7;--ink2:#e5e5ea;--ink3:#aeaeb2;--dim:#636366;
  --line:#3a3a3c;--bg:#111113;--white:#1c1c1e;
  --tea:#4ade80;--tea-d:#22c55e;--tea-l:#0d2e1a;--tea-p:#0a1f13;
  --topbar:#0a0a0c;--cats:#0d110e;
}

html,body{height:100%;overflow:hidden;font-family:'DM Sans',sans-serif;background:var(--bg);color:var(--ink);-webkit-font-smoothing:antialiased;transition:background .25s,color .25s}
.shell{display:grid;grid-template-rows:52px 1fr;grid-template-columns:210px 1fr 330px;height:100vh}

/* ── Mobile: stack layout ── */
@media(max-width:900px){
  .shell{grid-template-columns:1fr;grid-template-rows:52px 1fr}
  .cats{display:none}
  .cart-panel{
    position:fixed;bottom:0;left:0;right:0;
    height:auto;max-height:70vh;
    z-index:200;border-top:2px solid var(--line);
    border-left:none;
    transform:translateY(100%);
    transition:transform .3s ease;
    border-radius:18px 18px 0 0;
    overflow:hidden;
  }
  .cart-panel.show{transform:translateY(0)}
  .cart-foot{padding-bottom:env(safe-area-inset-bottom,16px)}
  .prod-panel{grid-column:1;height:calc(100vh - 52px);overflow:hidden;display:flex;flex-direction:column}
  .prod-grid{flex:1;overflow-y:auto}
  .cart-fab{display:flex!important}
  .shell{grid-template-columns:1fr}
}

@media(min-width:901px){
  .cart-fab{display:none!important}
  .cart-panel{transform:none!important}
  .cat-tabs-mobile{display:none!important}
}

/* FAB tombol buka cart */
.cart-fab{
  display:none;
  position:fixed;bottom:16px;right:16px;
  width:56px;height:56px;
  background:var(--tea);color:#fff;
  border:none;border-radius:50%;
  font-size:22px;
  box-shadow:0 4px 20px rgba(61,107,79,.4);
  cursor:pointer;z-index:300;
  align-items:center;justify-content:center;
  transition:transform .15s;
}
.cart-fab:hover{transform:scale(1.08)}
.cart-fab .fab-badge{
  position:absolute;top:-4px;right:-4px;
  background:#e63946;color:#fff;
  width:20px;height:20px;border-radius:50%;
  font-size:11px;font-weight:700;
  display:none;align-items:center;justify-content:center;
}
.cart-fab .fab-badge.show{display:flex}

/* Overlay untuk cart mobile */
.cart-overlay{
  display:none;position:fixed;inset:0;
  background:rgba(0,0,0,.4);z-index:199;
}
.cart-overlay.show{display:block}

/* Category tabs mobile */
.cat-tabs-mobile{
  display:none;overflow-x:auto;
  padding:8px 12px;gap:8px;
  background:var(--white);border-bottom:1px solid var(--line);
  flex-shrink:0;
}
.cat-tabs-mobile::-webkit-scrollbar{height:0}
.cat-tab-pill{
  padding:6px 14px;border-radius:20px;
  border:1.5px solid var(--line);background:var(--white);
  font-size:13px;font-weight:500;cursor:pointer;
  white-space:nowrap;color:var(--ink3);
  transition:all .12s;flex-shrink:0;
  font-family:inherit;
}
.cat-tab-pill.on{background:var(--tea);border-color:var(--tea);color:#fff}
@media(max-width:900px){.cat-tabs-mobile{display:flex}}

/* ── MOBILE OVERRIDES ── */
@media(max-width:900px){

  /* Kategori: grid 2 kolom atas-bawah, bukan scroll */
  .cat-tabs-mobile{
    display:grid !important;
    grid-template-columns:1fr 1fr;
    overflow-x:visible;
    padding:10px 12px;
    gap:6px;
  }
  .cat-tab-pill{
    text-align:center;
    padding:8px 6px;
    font-size:13px;
    border-radius:10px;
    white-space:normal;
  }

  /* Grid produk: 2 kolom rapi */
  .prod-grid{
    grid-template-columns:repeat(2, 1fr) !important;
    gap:10px;
    padding:12px;
  }

  /* Kartu produk: gambar lebih tinggi, info lebih bersih */
  .pcard .thumb{
    height:160px !important;
  }
  .pcard .info{
    padding:10px 12px 12px;
  }
  .pcard .pname{
    font-size:14px !important;
    font-weight:700;
    margin-bottom:4px;
    white-space:normal;
    line-height:1.3;
    display:-webkit-box;
    -webkit-line-clamp:2;
    -webkit-box-orient:vertical;
    overflow:hidden;
  }
  .pcard .pprice{
    font-size:15px !important;
    font-weight:800;
  }
  .pcard .pstock{
    font-size:12px !important;
  }
}
.topbar{grid-column:1/-1;background:var(--topbar);display:flex;align-items:center;padding:0 18px;gap:14px;transition:background .25s}
.brand{display:flex;align-items:center;gap:8px;color:#fff;font-family:'Instrument Sans',sans-serif;font-weight:700;font-size:15px;text-decoration:none}
.topbar-sep{width:1px;height:22px;background:#3a3a3c}
.topbar-clock{font-size:12px;color:var(--dim);letter-spacing:.3px}
.topbar-gap{flex:1}
.topbar-user{display:flex;align-items:center;gap:8px}
.topbar-av{width:28px;height:28px;border-radius:50%;background:var(--tea);display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:#fff;flex-shrink:0}
.topbar-nm{font-size:13px;color:#e5e5ea;font-weight:500}
.topbar-rl{font-size:11px;color:var(--dim);text-transform:capitalize}
.tbtn{padding:5px 12px;border-radius:7px;background:transparent;border:1px solid #3a3a3c;color:#aeaeb2;font-size:12px;font-family:inherit;cursor:pointer;text-decoration:none;display:flex;align-items:center;gap:5px;transition:all .15s}

/* ── TOPBAR MOBILE ── */
@media(max-width:900px){
  .topbar{padding:0 12px;gap:8px}
  .topbar-sep{display:none}
  .topbar-clock{display:none}
  .topbar-user .topbar-nm{display:none}
  .topbar-user .topbar-rl{display:none}
  .tbtn span{display:none}
  .tbtn{padding:5px 8px;min-width:32px;justify-content:center}
  .brand{font-size:14px}
  .brand svg{width:26px;height:26px}
}
@media(max-width:480px){
  .tbtn.hide-xs{display:none}
}
.theme-btn{
  width:36px;height:36px;border-radius:9px;
  border:1px solid rgba(255,255,255,.12);
  background:rgba(255,255,255,.07);
  color:#e5e5ea;
  display:flex;align-items:center;justify-content:center;
  cursor:pointer;font-size:15px;
  transition:all .15s;flex-shrink:0;
}
.theme-btn:hover{background:rgba(255,255,255,.14);border-color:rgba(255,255,255,.2);}
[data-theme="dark"] .theme-btn{background:rgba(255,255,255,.1);color:#fbbf24;}
.tbtn:hover{background:#2c2c2e;color:#e5e5ea;border-color:#48484a}
.cats{background:var(--cats);padding:14px 10px;display:flex;flex-direction:column;gap:2px;overflow-y:auto;transition:background .25s}
.cats::-webkit-scrollbar{width:0}
.cat-section{font-size:10px;font-weight:600;letter-spacing:.9px;text-transform:uppercase;color:#48484a;padding:10px 10px 6px}
.cat-btn{display:flex;align-items:center;gap:10px;padding:9px 12px;border-radius:9px;border:none;background:transparent;color:#8e8e93;font-size:13.5px;font-family:inherit;font-weight:500;cursor:pointer;width:100%;text-align:left;transition:all .15s}
.cat-btn .ico{font-size:18px;flex-shrink:0}
.cat-btn .lbl{flex:1}
.cat-btn .num{font-size:11px;color:#48484a;background:#2c2c2e;padding:1px 7px;border-radius:20px}
.cat-btn:hover{background:#2c2c2e;color:#d1d1d6}
.cat-btn.on{background:var(--tea);color:#fff}
.cat-btn.on .num{background:rgba(255,255,255,.2);color:#fff}
.prod-panel{display:flex;flex-direction:column;overflow:hidden;background:var(--bg)}
.search-bar{padding:12px 16px;background:var(--white);border-bottom:1px solid var(--line);flex-shrink:0}
.search-inner{position:relative}
.search-inner i{position:absolute;left:13px;top:50%;transform:translateY(-50%);color:var(--dim);font-size:14px;pointer-events:none}
.search-inner input{width:100%;height:40px;padding:0 14px 0 38px;background:var(--bg);border:1.5px solid transparent;border-radius:9px;font-size:14px;font-family:inherit;color:var(--ink);transition:all .15s}
.search-inner input::placeholder{color:var(--dim)}
.search-inner input:focus{outline:none;background:var(--white);border-color:var(--tea)}
.prod-grid{flex:1;overflow-y:auto;padding:14px;display:grid;grid-template-columns:repeat(auto-fill,minmax(145px,1fr));gap:10px;align-content:start}
.prod-grid::-webkit-scrollbar{width:5px}
.prod-grid::-webkit-scrollbar-thumb{background:#d1d1d6;border-radius:10px}
.pcard{background:var(--white);border-radius:13px;overflow:hidden;cursor:pointer;border:2px solid transparent;transition:border-color .15s,box-shadow .15s,transform .1s;user-select:none}
.pcard:hover{border-color:var(--tea);box-shadow:0 4px 18px rgba(61,107,79,.13)}
.pcard:active{transform:scale(.97)}
.pcard.sold{opacity:.4;cursor:not-allowed;pointer-events:none}
.pcard .thumb{height:108px;background:var(--tea-p);display:flex;align-items:center;justify-content:center;position:relative;overflow:hidden}
.pcard .thumb img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover}
.pcard .thumb svg{width:70px;height:70px}
.pcard .info{padding:9px 11px 11px}
.pcard .pname{font-size:13px;font-weight:600;color:var(--ink2);line-height:1.3;margin-bottom:4px}
.pcard .pprice{font-size:14px;font-weight:700;color:var(--tea);font-family:'Instrument Sans',sans-serif}
.pcard .pstock{font-size:11px;color:var(--dim);margin-top:2px}
@keyframes steam{0%{transform:translateY(0) scaleX(1);opacity:.6}50%{transform:translateY(-6px) scaleX(1.15);opacity:.35}100%{transform:translateY(-12px) scaleX(.9);opacity:0}}
.s1{animation:steam 2s ease-in-out infinite}
.s2{animation:steam 2s ease-in-out infinite .6s}
.s3{animation:steam 2s ease-in-out infinite 1.2s}
.cart-panel{background:#f7f8f6;border-left:1px solid var(--line);display:flex;flex-direction:column;overflow:hidden}
.cart-head{padding:14px 16px 12px;background:var(--white);border-bottom:1px solid var(--line);display:flex;align-items:center;justify-content:space-between;flex-shrink:0}
.cart-title{font-family:'Instrument Sans',sans-serif;font-weight:700;font-size:15px;display:flex;align-items:center;gap:8px;color:var(--ink)}
.cart-badge{background:var(--tea);color:#fff;font-size:11px;font-weight:700;padding:2px 8px;border-radius:20px;display:none;font-family:'Instrument Sans',sans-serif}
.btn-clr{font-size:12px;color:var(--ink3);background:transparent;border:none;padding:4px 8px;border-radius:6px;cursor:pointer;font-family:inherit;display:none;transition:all .12s;align-items:center;gap:4px}
.btn-clr:hover{background:#fee2e2;color:#b91c1c}
.cart-list{flex:1;overflow-y:auto;padding:10px 12px;display:flex;flex-direction:column;gap:6px}
.cart-list::-webkit-scrollbar{width:3px}
.cart-list::-webkit-scrollbar-thumb{background:#d1d5db;border-radius:10px}
.empty-state{flex:1;display:flex;flex-direction:column;align-items:center;justify-content:center;color:#d1d5db;gap:8px;padding-bottom:40px}
.empty-state .etxt{font-size:12px;color:var(--dim);letter-spacing:.2px}
.ci{background:var(--white);border-radius:11px;padding:10px 12px;display:flex;align-items:center;gap:10px;border:1px solid #f0f0f0}
.ci-num{width:24px;height:24px;background:var(--tea-p);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:var(--tea);flex-shrink:0}
.ci-info{flex:1;min-width:0}
.ci-name{font-size:13px;font-weight:600;color:var(--ink2);white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.ci-price{font-size:11px;color:var(--dim);margin-top:2px}
.ci-right{display:flex;flex-direction:column;align-items:flex-end;gap:5px;flex-shrink:0}
.ci-sub{font-size:13px;font-weight:700;color:var(--tea);font-family:'Instrument Sans',sans-serif;white-space:nowrap}
.qc{display:flex;align-items:center;gap:4px}
.qb{width:24px;height:24px;border-radius:7px;border:1.5px solid var(--line);background:var(--bg);font-size:14px;font-weight:700;color:var(--ink2);display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all .12s;line-height:1;padding:0;flex-shrink:0}
.qb:hover{background:var(--tea);border-color:var(--tea);color:#fff}
.qn{font-size:14px;font-weight:700;min-width:22px;text-align:center;color:var(--ink)}
.cart-foot{background:var(--white);border-top:1px solid var(--line);padding:14px 16px 16px;flex-shrink:0}
.cust-row{display:flex;align-items:center;gap:8px;background:var(--bg);border-radius:9px;padding:8px 12px;margin-bottom:12px;border:1.5px solid transparent;transition:border-color .15s}
.cust-row:focus-within{border-color:var(--tea);background:var(--white)}
.cust-row i{color:var(--dim);font-size:14px;flex-shrink:0}
.cust-inp{flex:1;border:none;background:transparent;font-size:13px;font-family:inherit;color:var(--ink);outline:none}
.cust-inp::placeholder{color:var(--dim)}
.sum-block{background:var(--bg);border-radius:10px;padding:10px 12px;margin-bottom:12px}
.sum-row{display:flex;justify-content:space-between;font-size:12.5px;color:var(--ink3);align-items:center;padding:3px 0}
.sum-row+.sum-row{border-top:1px dashed #ebebeb;margin-top:3px;padding-top:6px}
.sum-val{font-weight:600;color:var(--ink2);font-family:'Instrument Sans',sans-serif;font-size:13px}
.disc-wrap{display:flex;align-items:center;gap:4px}
.disc-wrap span{font-size:12px;color:var(--dim)}
.disc-inp{width:72px;border:1.5px solid var(--line);border-radius:6px;padding:3px 7px;font-size:12px;text-align:right;font-family:'Instrument Sans',sans-serif;color:var(--ink);background:var(--white)}
.disc-inp:focus{outline:none;border-color:var(--tea)}
.total-row{display:flex;justify-content:space-between;align-items:center;padding:11px 13px;background:var(--tea-p);border-radius:11px;margin-bottom:12px;border:1.5px solid var(--tea-l)}
.total-lbl{font-size:13px;font-weight:600;color:#4a7c5f}
.total-val{font-size:22px;font-weight:800;color:var(--tea);font-family:'Instrument Sans',sans-serif;letter-spacing:-.5px}
.pay-btn{width:100%;background:var(--tea);color:#fff;border:none;border-radius:11px;padding:13px;font-size:15px;font-weight:700;font-family:'Instrument Sans',sans-serif;cursor:pointer;transition:background .15s,transform .1s;display:flex;align-items:center;justify-content:center;gap:8px}
.pay-btn:hover:not(:disabled){background:var(--tea-d)}
.pay-btn:active:not(:disabled){transform:scale(.98)}
.pay-btn:disabled{background:#c8d5cc;color:#8fa898;cursor:not-allowed}
.overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.48);z-index:300;align-items:center;justify-content:center}
.overlay.show{display:flex}
.modal-box{background:var(--white);border-radius:18px;width:440px;max-width:95vw;box-shadow:0 24px 60px rgba(0,0,0,.22);animation:pop .2s ease;transition:width .25s ease;overflow:hidden}
@keyframes pop{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:translateY(0)}}
.mh{padding:18px 22px 14px;border-bottom:1px solid var(--line);display:flex;align-items:center;justify-content:space-between}
.mh-title{font-family:'Instrument Sans',sans-serif;font-size:16px;font-weight:700}
.mh-close{width:28px;height:28px;border-radius:50%;border:none;background:var(--bg);color:var(--ink3);font-size:14px;cursor:pointer;display:flex;align-items:center;justify-content:center}
.mh-close:hover{background:var(--line)}
.mb{padding:18px 22px}
.mf{padding:14px 22px 20px;border-top:1px solid var(--line);display:flex;justify-content:space-between;align-items:center}
.amt-box{background:var(--tea-p);border-radius:12px;padding:14px 16px;margin-bottom:18px;display:flex;justify-content:space-between;align-items:center}
.amt-lbl{font-size:12px;color:#4f7a60;font-weight:500}
.amt-val{font-size:26px;font-weight:800;color:var(--tea);font-family:'Instrument Sans',sans-serif;letter-spacing:-.5px}
.amt-cnt{font-size:12px;color:#7fad90;margin-top:2px}
.meth-lbl{font-size:12px;font-weight:600;color:var(--ink3);text-transform:uppercase;letter-spacing:.5px;margin-bottom:8px}
.meth-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:8px;margin-bottom:18px}
.meth{border:2px solid var(--line);border-radius:10px;padding:12px 6px;background:var(--white);text-align:center;cursor:pointer;transition:all .12s;font-family:inherit}
.meth i{display:block;font-size:22px;color:var(--ink3);margin-bottom:5px}
.meth span{font-size:12px;font-weight:600;color:var(--ink3)}
.meth:hover{border-color:var(--tea)}
.meth.on{border-color:var(--tea);background:var(--tea-l)}
.meth.on i,.meth.on span{color:var(--tea)}
.pay-lbl{font-size:12px;font-weight:600;color:var(--ink3);text-transform:uppercase;letter-spacing:.5px;margin-bottom:8px}
.pay-inp-wr{position:relative;margin-bottom:10px}
.pay-inp-wr .pfx{position:absolute;left:14px;top:50%;transform:translateY(-50%);font-size:14px;font-weight:700;color:var(--dim);font-family:'Instrument Sans',sans-serif;pointer-events:none}
.pay-inp-wr input{width:100%;height:50px;padding:0 14px 0 44px;border:2px solid var(--line);border-radius:11px;font-size:22px;font-weight:800;font-family:'Instrument Sans',sans-serif;color:var(--ink);letter-spacing:-.3px;transition:border-color .15s}
.pay-inp-wr input:focus{outline:none;border-color:var(--tea)}
.quick-btns{display:flex;flex-wrap:wrap;gap:6px;margin-bottom:14px}
.quick-btns button{padding:5px 12px;border:1.5px solid var(--line);border-radius:8px;background:var(--bg);font-size:12px;font-weight:600;font-family:'Instrument Sans',sans-serif;color:var(--ink2);cursor:pointer;transition:all .12s}
.quick-btns button:hover{border-color:var(--tea);background:var(--tea-l);color:var(--tea)}
.change-box{display:flex;justify-content:space-between;align-items:center;background:var(--bg);border-radius:10px;padding:11px 14px}
.chg-lbl{font-size:13px;font-weight:600;color:var(--ink3)}
.chg-val{font-size:20px;font-weight:800;color:var(--tea);font-family:'Instrument Sans',sans-serif;letter-spacing:-.3px}
.noncash-info{background:#f0f8ff;border-radius:10px;padding:13px 14px;font-size:13px;color:#2d6a9f}
.btn-cancel{padding:10px 20px;border-radius:10px;border:1.5px solid var(--line);background:var(--white);font-size:14px;font-weight:600;font-family:inherit;color:var(--ink3);cursor:pointer}
.btn-cancel:hover{background:var(--bg)}
.btn-ok{padding:10px 26px;border-radius:10px;border:none;background:var(--tea);color:#fff;font-size:14px;font-weight:700;font-family:'Instrument Sans',sans-serif;cursor:pointer;transition:background .15s}
.btn-ok:hover{background:var(--tea-d)}
.btn-ok:disabled{background:var(--dim);cursor:not-allowed}
.success-inner{text-align:center;padding:32px 24px 28px}
.sttl{font-size:20px;font-weight:800;font-family:'Instrument Sans',sans-serif;margin-bottom:4px;margin-top:12px}
.sinv{font-size:12px;color:var(--dim);font-family:monospace;margin-bottom:4px}
.schg{font-size:18px;font-weight:700;color:var(--tea);margin-bottom:22px;font-family:'Instrument Sans',sans-serif}
.sbtns{display:flex;flex-direction:column;gap:8px}
.sbtns a,.sbtns button{padding:11px;border-radius:10px;font-size:14px;font-weight:600;font-family:'Instrument Sans',sans-serif;cursor:pointer;border:none;text-decoration:none;display:block;text-align:center}
.btn-print{background:var(--bg);color:var(--ink2);border:1.5px solid var(--line) !important}
.btn-print:hover{background:var(--line)}
.btn-new{background:var(--tea);color:#fff}
.btn-new:hover{background:var(--tea-d)}
.toast{position:fixed;bottom:22px;left:50%;transform:translateX(-50%);background:var(--ink);color:#fff;padding:9px 20px;border-radius:100px;font-size:13px;font-weight:500;z-index:400;opacity:0;transition:opacity .2s;pointer-events:none;white-space:nowrap}
.toast.show{opacity:1}

/* ── DARK MODE overrides ── */
[data-theme="dark"] .pcard{background:#252527;border-color:#3a3a3c}
[data-theme="dark"] .pcard:hover{border-color:var(--tea);box-shadow:0 4px 18px rgba(74,222,128,.15)}
[data-theme="dark"] .pcard .pname{color:#e5e5ea}
[data-theme="dark"] .search-bar,[data-theme="dark"] .cart-head,[data-theme="dark"] .cart-foot{background:#1c1c1e;border-color:#3a3a3c}
[data-theme="dark"] .search-inner input{background:#2c2c2e;color:#f2f2f7;border-color:#3a3a3c}
[data-theme="dark"] .search-inner input:focus{background:#2c2c2e;border-color:var(--tea)}
[data-theme="dark"] .cart-panel{background:#111113;border-color:#3a3a3c}
[data-theme="dark"] .ci{background:#252527;border-color:#3a3a3c}
[data-theme="dark"] .ci-name{color:#e5e5ea}
[data-theme="dark"] .sum-block{background:#252527}
[data-theme="dark"] .disc-inp{background:#1c1c1e;border-color:#3a3a3c;color:#f2f2f7}
[data-theme="dark"] .total-row{background:#0a1f13;border-color:#166534}
[data-theme="dark"] .cust-row{background:#252527;border-color:transparent}
[data-theme="dark"] .cust-inp{color:#f2f2f7}
[data-theme="dark"] .qb{background:#252527;border-color:#3a3a3c;color:#e5e5ea}
[data-theme="dark"] .modal-box{background:#1c1c1e}
[data-theme="dark"] .mh{border-color:#3a3a3c}
[data-theme="dark"] .mh-title{color:#f2f2f7}
[data-theme="dark"] .mf{border-color:#3a3a3c}
[data-theme="dark"] .amt-box{background:#0a1f13}
[data-theme="dark"] .meth{background:#252527;border-color:#3a3a3c}
[data-theme="dark"] .meth span{color:#aeaeb2}
[data-theme="dark"] .meth i{color:#aeaeb2}
[data-theme="dark"] .meth.on{background:#0a1f13;border-color:var(--tea)}
[data-theme="dark"] .pay-inp-wr input{background:#252527;border-color:#3a3a3c;color:#f2f2f7}
[data-theme="dark"] .quick-btns button{background:#252527;border-color:#3a3a3c;color:#e5e5ea}
[data-theme="dark"] .change-box{background:#252527}
[data-theme="dark"] .chg-lbl{color:#aeaeb2}
[data-theme="dark"] .btn-cancel{background:#252527;border-color:#3a3a3c;color:#aeaeb2}
[data-theme="dark"] .success-inner{background:#1c1c1e}
[data-theme="dark"] .sttl{color:#f2f2f7}
[data-theme="dark"] .btn-print{background:#252527;color:#e5e5ea;border-color:#3a3a3c !important}
[data-theme="dark"] .empty-state .etxt{color:#636366}
[data-theme="dark"] .prod-panel{background:#111113}
</style>
</head>
<body>
<div class="shell">

{{-- TOPBAR --}}
<header class="topbar">
  <a href="{{ route('dashboard') }}" class="brand">
    <svg width="32" height="32" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
      <circle cx="22" cy="22" r="22" fill="#d4522a"/>
      <circle cx="22" cy="22" r="18" fill="#ffffff"/>
      <circle cx="22" cy="22" r="11" fill="#f97316" stroke="#d4522a" stroke-width="1.5"/>
      <circle cx="22" cy="22" r="5" fill="#ffffff"/>
      <rect x="16" y="12" width="3" height="1.5" rx="0.75" fill="#ec4899" transform="rotate(-30 16 12)"/>
      <rect x="26" y="13" width="3" height="1.5" rx="0.75" fill="#3b82f6" transform="rotate(20 26 13)"/>
      <rect x="29" y="21" width="3" height="1.5" rx="0.75" fill="#22c55e" transform="rotate(-10 29 21)"/>
      <rect x="26" y="29" width="3" height="1.5" rx="0.75" fill="#f59e0b" transform="rotate(40 26 29)"/>
      <rect x="16" y="30" width="3" height="1.5" rx="0.75" fill="#ec4899" transform="rotate(-20 16 30)"/>
      <rect x="12" y="22" width="3" height="1.5" rx="0.75" fill="#a855f7" transform="rotate(10 12 22)"/>
      <text x="22" y="24.5" text-anchor="middle" font-family="Arial Black,sans-serif" font-weight="900" font-size="5.5" fill="#7c2d12">DONIK</text>
      <text x="22" y="30.5" text-anchor="middle" font-family="Arial Black,sans-serif" font-weight="900" font-size="4" fill="#7c2d12">DONUTS</text>
    </svg>
    Donik Donuts
  </a>
  <div class="topbar-sep"></div>
  <span class="topbar-clock" id="clk"></span>
  <div class="topbar-gap"></div>
  <div class="topbar-user">
    <div class="topbar-av">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</div>
    <div>
      <div class="topbar-nm">{{ auth()->user()->name }}</div>
      <div class="topbar-rl">{{ auth()->user()->role }}</div>
    </div>
  </div>
  <a href="{{ route('dashboard') }}" class="tbtn hide-xs"><i class="bi bi-grid-1x2"></i> <span>Beranda</span></a>
  <button class="theme-btn" id="themeBtn" onclick="toggleTheme()" title="Ganti tema">
    <i class="bi bi-moon-fill" id="themeIco"></i>
  </button>
  <form action="{{ route('logout') }}" method="POST" style="display:inline">
    @csrf
    <button type="submit" class="tbtn"><i class="bi bi-box-arrow-right"></i> <span>Keluar</span></button>
  </form>
</header>

{{-- CATEGORY SIDEBAR --}}
<aside class="cats">
  <div class="cat-section">Menu</div>
  <button class="cat-btn on" data-cat="all">
    <span class="ico"><i class="bi bi-list"></i></span>
    <span class="lbl">Semua</span>
    <span class="num" id="cnt-all">-</span>
  </button>
  @foreach($categories as $cat)
  @php
    $icons = [
      'TEA SERIES'    => '<i class="bi bi-cup-hot"></i>',
      'YAKULT SERIES' => '<i class="bi bi-droplet-fill"></i>',
      'BLEND SERIES'  => '<i class="bi bi-layers-fill"></i>',
      'COFFEE SERIES' => '<i class="bi bi-cup-fill"></i>',
    ];
  @endphp
  <button class="cat-btn" data-cat="{{ $cat->id }}">
    <span class="ico">{!! $icons[$cat->name] ?? '<i class="bi bi-cup"></i>' !!}</span>
    <span class="lbl">{{ $cat->name }}</span>
    <span class="num" id="cnt-{{ $cat->id }}">{{ $cat->products->count() }}</span>
  </button>
  @endforeach
</aside>

{{-- PRODUCT GRID --}}
<div class="prod-panel">
  <div class="search-bar">
    <div class="search-inner">
      <i class="bi bi-search"></i>
      <input id="srch" type="text" placeholder="Ketik nama minuman...">
    </div>
  </div>

  {{-- Category tabs mobile --}}
  <div class="cat-tabs-mobile" id="catTabsMobile">
    <button class="cat-tab-pill on" data-cat="all">Semua</button>
    @foreach($categories as $cat)
    <button class="cat-tab-pill" data-cat="{{ $cat->id }}">{{ $cat->name }}</button>
    @endforeach
  </div>

  <div class="prod-grid" id="grid">
    <div style="grid-column:1/-1;padding:50px;text-align:center;color:var(--dim);font-size:13px">Memuat...</div>
  </div>
</div>

{{-- CART --}}
<div class="cart-panel">
  <div class="cart-head">
    <div class="cart-title">
      <i class="bi bi-bag" style="font-size:15px;color:var(--tea)"></i>
      Pesanan
      <span class="cart-badge" id="badge">0</span>
    </div>
    <button class="btn-clr" id="btnClr">
      <i class="bi bi-trash3" style="font-size:11px"></i> Kosongkan
    </button>
  </div>

  <div class="empty-state" id="emptyState">
    <i class="bi bi-cup-straw" style="font-size:44px;color:#d1d5db"></i>
    <div class="etxt">Pilih minuman untuk mulai</div>
  </div>

  <div class="cart-list" id="cartList"></div>

  <div class="cart-foot">
    <div class="cust-row">
      <i class="bi bi-person"></i>
      <input class="cust-inp" id="custName" type="text" placeholder="Nama pelanggan (opsional)">
    </div>
    <div class="sum-block">
      <div class="sum-row">
        <span>Subtotal</span>
        <span class="sum-val" id="elSubtotal">Rp 0</span>
      </div>
      <div class="sum-row">
        <span>Diskon</span>
        <div class="disc-wrap">
          <span>Rp</span>
          <input class="disc-inp" id="elDiscount" type="number" value="0" min="0">
        </div>
      </div>
    </div>
    <div class="total-row">
      <span class="total-lbl">Total Bayar</span>
      <span class="total-val" id="elTotal">Rp 0</span>
    </div>
    <button class="pay-btn" id="btnPay" disabled>
      <i class="bi bi-credit-card-2-front" style="font-size:16px"></i>
      Bayar Sekarang
    </button>
  </div>
</div>

</div><!-- .shell -->

{{-- FAB Cart Button (mobile only) --}}
<button class="cart-fab" id="cartFab" onclick="toggleCartMobile()">
  <i class="bi bi-bag-fill"></i>
  <span class="fab-badge" id="fabBadge">0</span>
</button>

{{-- Cart Overlay (mobile) --}}
<div class="cart-overlay" id="cartOverlay" onclick="toggleCartMobile()"></div>

{{-- PAYMENT MODAL --}}
<div class="overlay" id="payOverlay">
  <div class="modal-box" id="payModalBox">
    <div class="mh">
      <span class="mh-title">Pembayaran</span>
      <button class="mh-close" id="btnClosePay"><i class="bi bi-x"></i></button>
    </div>

    <div style="display:flex;min-height:0">

      {{-- Kolom kiri: info + metode + cash input --}}
      <div id="payLeft" style="flex:1;padding:18px 22px;min-width:0">
        <div class="amt-box">
          <div>
            <div class="amt-lbl">Total tagihan</div>
            <div class="amt-val" id="mTotal">Rp 0</div>
            <div class="amt-cnt" id="mCount">0 item</div>
          </div>
          <svg width="42" height="42" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="22" cy="22" r="22" fill="#d4522a"/>
            <circle cx="22" cy="22" r="18" fill="#ffffff"/>
            <circle cx="22" cy="22" r="11" fill="#f97316" stroke="#d4522a" stroke-width="1.5"/>
            <circle cx="22" cy="22" r="5" fill="#ffffff"/>
            <rect x="16" y="12" width="3" height="1.5" rx="0.75" fill="#ec4899" transform="rotate(-30 16 12)"/>
            <rect x="26" y="13" width="3" height="1.5" rx="0.75" fill="#3b82f6" transform="rotate(20 26 13)"/>
            <rect x="29" y="21" width="3" height="1.5" rx="0.75" fill="#22c55e" transform="rotate(-10 29 21)"/>
            <rect x="26" y="29" width="3" height="1.5" rx="0.75" fill="#f59e0b" transform="rotate(40 26 29)"/>
            <rect x="16" y="30" width="3" height="1.5" rx="0.75" fill="#ec4899" transform="rotate(-20 16 30)"/>
            <rect x="12" y="22" width="3" height="1.5" rx="0.75" fill="#a855f7" transform="rotate(10 12 22)"/>
            <text x="22" y="24.5" text-anchor="middle" font-family="Arial Black,sans-serif" font-weight="900" font-size="5.5" fill="#7c2d12">DONIK</text>
            <text x="22" y="30.5" text-anchor="middle" font-family="Arial Black,sans-serif" font-weight="900" font-size="4" fill="#7c2d12">DONUTS</text>
          </svg>
        <div class="meth-lbl">Metode Pembayaran</div>
        <div class="meth-grid">
          <button class="meth on" data-m="cash"><i class="bi bi-cash"></i><span>Tunai</span></button>
          <button class="meth" data-m="qris"><i class="bi bi-qr-code-scan"></i><span>QRIS</span></button>
        </div>
        <div id="cashSec">
          <div class="pay-lbl">Uang Diterima</div>
          <div class="pay-inp-wr">
            <span class="pfx">Rp</span>
            <input type="number" id="paidInp" placeholder="0" min="0">
          </div>
          <div class="quick-btns" id="quickBtns"></div>
          <div class="change-box">
            <span class="chg-lbl">Kembalian</span>
            <span class="chg-val" id="elChange">Rp 0</span>
          </div>
        </div>
        <div id="noncashSec" style="display:none">
          <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;padding:12px 14px;margin-top:4px;text-align:center">
            <i class="bi bi-check-circle-fill" style="color:#16a34a;font-size:18px;display:block;margin-bottom:6px"></i>
            <div style="font-size:13px;font-weight:600;color:#166534;margin-bottom:2px">Scan QR Code di samping</div>
            <div style="font-size:12px;color:#4ade80">Konfirmasi setelah pembayaran selesai</div>
          </div>
        </div>
      </div>

      {{-- Kolom kanan: QRIS card (muncul saat QRIS dipilih) --}}
      <div id="qrisPanel" style="display:none;width:300px;flex-shrink:0;border-left:1px solid var(--line);overflow:hidden">
        <div style="background:#fff;height:100%">

          {{-- Header --}}
          <div style="display:flex;align-items:center;justify-content:space-between;padding:14px 18px 8px">
            <div style="display:flex;align-items:center;gap:8px">
              <div style="background:#e63946;border-radius:5px;padding:4px 9px">
                <span style="color:#fff;font-size:12px;font-weight:900;letter-spacing:1px">QRIS</span>
              </div>
              <div style="line-height:1.3">
                <div style="font-size:9px;font-weight:700;color:#111">QR Code Standar</div>
                <div style="font-size:8px;color:#888">Pembayaran Nasional</div>
              </div>
            </div>
            <div style="display:flex;align-items:center;gap:5px">
              <svg width="20" height="20" viewBox="0 0 30 30" fill="none">
                <polygon points="15,2 27,8.5 27,21.5 15,28 3,21.5 3,8.5" fill="#e63946"/>
                <polygon points="15,7 23,11.5 23,18.5 15,23 7,18.5 7,11.5" fill="#fff"/>
                <polygon points="15,12 19,14.5 19,17.5 15,20 11,17.5 11,14.5" fill="#e63946"/>
              </svg>
              <span style="font-size:10px;font-weight:900;color:#e63946">GPN</span>
            </div>
          </div>

          {{-- Merchant --}}
          <div style="text-align:center;padding:0 16px 8px">
            <div style="font-size:14px;font-weight:800;color:#111;margin-bottom:2px">Donik Donuts</div>
            <div style="font-size:9px;color:#777;margin-bottom:1px">NMID: ID2026090900001</div>
            <div style="font-size:9px;color:#777">TID: TK-001</div>
          </div>

          {{-- QR Code --}}
          <div style="display:flex;justify-content:center;padding:0 16px 8px">
            <div id="qrisCanvas" style="border:2px solid #111;border-radius:8px;padding:8px;background:#fff;display:inline-block"></div>
          </div>

          {{-- Tagline --}}
          <div style="text-align:center;padding:0 16px 8px">
            <div style="font-size:10px;font-weight:800;color:#111;letter-spacing:.5px;margin-bottom:2px">SATU QRIS UNTUK SEMUA</div>
            <div style="font-size:9px;color:#666;margin-bottom:1px">Cek aplikasi penyelenggara</div>
            <div style="font-size:9px;color:#e63946;font-weight:600">di: www.aspi-qris.id</div>
          </div>

          {{-- Footer merah --}}
          <div style="background:#e63946;padding:7px 14px;display:flex;align-items:center;justify-content:space-between">
            <div style="font-size:7px;color:rgba(255,255,255,.8);line-height:1.6">
              Donik Donuts POS<br>v1.0
            </div>
            <div style="display:flex;gap:8px">
              <div style="text-align:center">
                <div style="width:20px;height:20px;background:rgba(255,255,255,.25);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 2px">
                  <i class="bi bi-phone" style="font-size:9px;color:#fff"></i>
                </div>
                <div style="font-size:6px;color:rgba(255,255,255,.9)">Buka Aplikasi</div>
              </div>
              <div style="text-align:center">
                <div style="width:20px;height:20px;background:rgba(255,255,255,.25);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 2px">
                  <i class="bi bi-qr-code-scan" style="font-size:9px;color:#fff"></i>
                </div>
                <div style="font-size:6px;color:rgba(255,255,255,.9)">Scan & Cek</div>
              </div>
              <div style="text-align:center">
                <div style="width:20px;height:20px;background:rgba(255,255,255,.25);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 2px">
                  <i class="bi bi-check-lg" style="font-size:9px;color:#fff"></i>
                </div>
                <div style="font-size:6px;color:rgba(255,255,255,.9)">Bayar</div>
              </div>
            </div>
          </div>

          {{-- Total --}}
          <div style="padding:10px 16px;text-align:center;border-top:1px solid #f3f4f6">
            <div style="font-size:9px;font-weight:600;color:#888;text-transform:uppercase;letter-spacing:.3px;margin-bottom:3px">Total Pembayaran</div>
            <div class="qris-total-val" style="font-size:22px;font-weight:800;color:#e63946;letter-spacing:-.5px">Rp 0</div>
          </div>

        </div>
      </div>

    </div>{{-- end flex row --}}

    <div class="mf">
      <button class="btn-cancel" id="btnCancelPay">Batal</button>
      <button class="btn-ok" id="btnConfirm">Konfirmasi</button>
    </div>
  </div>
</div>

{{-- SUCCESS MODAL --}}
<div class="overlay" id="okOverlay">
  <div class="modal-box">
    <div class="success-inner">
      <i class="bi bi-check-circle-fill" style="font-size:52px;color:#3d6b4f"></i>
      <div class="sttl">Transaksi Berhasil!</div>
      <div class="sinv" id="sInv"></div>
      <div class="schg" id="sChg"></div>
      <div class="sbtns">
        <a class="btn-print" id="sPrint" href="#" target="_blank">
          <i class="bi bi-printer"></i> Cetak Struk
        </a>
        <button class="btn-new" id="btnNew">
          <i class="bi bi-plus"></i> Transaksi Baru
        </button>
      </div>
    </div>
  </div>
</div>

<div class="toast" id="toastEl"></div>

<script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
<script>
(function () {
  'use strict';

  var qrInstance = null;

  const CSRF  = document.querySelector('meta[name="csrf-token"]').content;
  let products  = [];
  let cart      = {};
  let curCat    = 'all';
  let payMethod = 'cash';

  /* Clock */
  const DAYS = ['Min','Sen','Sel','Rab','Kam','Jum','Sab'];
  function tick() {
    const n = new Date();
    document.getElementById('clk').textContent =
      DAYS[n.getDay()] + ' ' +
      n.toLocaleDateString('id-ID',{day:'2-digit',month:'short',year:'numeric'}) +
      '  ' + n.toLocaleTimeString('id-ID',{hour:'2-digit',minute:'2-digit',second:'2-digit'});
  }
  setInterval(tick, 1000); tick();

  /* Rupiah */
  function rp(n) {
    return 'Rp\u00a0' + Math.round(Number(n)).toLocaleString('id-ID');
  }

  /* Toast */
  function toast(msg) {
    const el = document.getElementById('toastEl');
    el.textContent = msg;
    el.classList.add('show');
    clearTimeout(el._t);
    el._t = setTimeout(() => el.classList.remove('show'), 2800);
  }

  /* SVG Cup */
  function cupSVG(name) {
    const n = name.toLowerCase();
    let c = '#c8832a';
    if (n.includes('coffee') || n.includes('latte') || n.includes('cappuccino') || n.includes('americano') || n.includes('dalgona') || n.includes('vietnam') || n.includes('hazelnut') || n.includes('caramel')) c = '#6b3a2a';
    else if (n.includes('yakult'))                                             c = '#f4a261';
    else if (n.includes('matcha'))                                             c = '#6aaa64';
    else if (n.includes('taro'))                                               c = '#9b72cf';
    else if (n.includes('thai'))                                               c = '#e07b39';
    else if (n.includes('strawberry'))                                         c = '#e05c7a';
    else if (n.includes('lemon'))                                              c = '#c8b832';
    else if (n.includes('peach') || n.includes('mango'))                       c = '#f4a261';
    else if (n.includes('brown sugar') || n.includes('okinawa'))               c = '#8b5e3c';
    else if (n.includes('cheese'))                                             c = '#f4d03f';
    else if (n.includes('wintermelon'))                                        c = '#7ec8a0';
    else if (n.includes('grape'))                                              c = '#8e44ad';
    else if (n.includes('jasmine'))                                            c = '#a0c878';
    else if (n.includes('passion'))                                            c = '#e05c7a';
    return '<svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">'
      + '<path class="s1" d="M30 18 Q28 13 30 8" stroke="#9cbe9c" stroke-width="1.8" stroke-linecap="round"/>'
      + '<path class="s2" d="M40 16 Q38 10 40 5" stroke="#9cbe9c" stroke-width="1.8" stroke-linecap="round"/>'
      + '<path class="s3" d="M50 18 Q48 13 50 8" stroke="#9cbe9c" stroke-width="1.8" stroke-linecap="round"/>'
      + '<ellipse cx="40" cy="66" rx="22" ry="5" fill="#e0d5c8"/>'
      + '<ellipse cx="40" cy="64" rx="18" ry="3.5" fill="#ecdfd2"/>'
      + '<path d="M20 32 Q19 55 28 60 Q40 64 52 60 Q61 55 60 32 Z" fill="white"/>'
      + '<path d="M22 38 Q21 55 29 59 Q40 63 51 59 Q59 55 58 38 Z" fill="' + c + '" opacity=".85"/>'
      + '<ellipse cx="40" cy="32" rx="20" ry="5" fill="white"/>'
      + '<ellipse cx="40" cy="32" rx="20" ry="5" fill="' + c + '" opacity=".15"/>'
      + '<ellipse cx="40" cy="32" rx="20" ry="5" stroke="#d8cfc6" stroke-width="1"/>'
      + '<path d="M60 38 Q72 38 72 47 Q72 56 60 56" stroke="white" stroke-width="4" fill="none" stroke-linecap="round"/>'
      + '<path d="M60 38 Q70 38 70 47 Q70 54 60 54" stroke="#d8cfc6" stroke-width="1" fill="none"/>'
      + '<path d="M26 40 Q27 52 30 57" stroke="white" stroke-width="1.5" stroke-linecap="round" opacity=".6"/>'
      + '</svg>';
  }

  /* Load Products */
  async function loadProducts() {
    const grid = document.getElementById('grid');
    grid.innerHTML = '<div style="grid-column:1/-1;padding:50px;text-align:center;color:var(--dim);font-size:13px">Memuat...</div>';
    try {
      const res = await fetch('{{ route("pos.products") }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
        body: JSON.stringify({ category_id: curCat, search: document.getElementById('srch').value }),
      });
      products = await res.json();
      renderProducts();
      document.getElementById('cnt-all').textContent = products.length;
    } catch(err) {
      grid.innerHTML = '<div style="grid-column:1/-1;padding:50px;text-align:center;color:#c0392b;font-size:13px">Gagal memuat produk</div>';
    }
  }

  function renderProducts() {
    const grid = document.getElementById('grid');
    if (!products.length) {
      grid.innerHTML = '<div style="grid-column:1/-1;padding:60px;text-align:center;color:var(--dim);font-size:13px">Tidak ada produk</div>';
      return;
    }
    grid.innerHTML = products.map(function(p) {
      var sold = p.stock <= 0;
      var img  = (p.image_url && p.image_url.indexOf('no-image') === -1)
        ? '<img src="' + p.image_url + '" alt="">'
        : cupSVG(p.name);
      return '<div class="pcard' + (sold ? ' sold' : '') + '" data-pid="' + p.id + '">'
        + '<div class="thumb">' + img + '</div>'
        + '<div class="info">'
        + '<div class="pname">' + p.name + '</div>'
        + '<div class="pprice">' + rp(p.price) + '</div>'
        + '<div class="pstock">' + (sold ? 'Habis' : 'Stok ' + p.stock) + '</div>'
        + '</div></div>';
    }).join('');
  }

  /* Product click */
  document.getElementById('grid').addEventListener('click', function(e) {
    var card = e.target.closest('.pcard');
    if (!card || card.classList.contains('sold')) return;
    addToCart(Number(card.dataset.pid));
  });

  /* Cart */
  function addToCart(id) {
    var p = null;
    for (var i = 0; i < products.length; i++) {
      if (products[i].id === id) { p = products[i]; break; }
    }
    if (!p) return;
    if (cart[id]) {
      if (cart[id].qty >= p.stock) { toast('Stok ' + p.name + ' hanya ' + p.stock); return; }
      cart[id].qty++;
    } else {
      cart[id] = { id: p.id, name: p.name, price: Number(p.price), stock: p.stock, qty: 1 };
    }
    renderCart();
    updateSummary();
  }

  function changeQty(id, d) {
    if (!cart[id]) return;
    cart[id].qty += d;
    if (cart[id].qty <= 0) delete cart[id];
    renderCart();
    updateSummary();
  }

  function clearCart() {
    cart = {};
    renderCart();
    updateSummary();
  }

  function renderCart() {
    var items    = Object.values(cart);
    var totalQty = items.reduce(function(s,i){ return s + i.qty; }, 0);

    var badge = document.getElementById('badge');
    badge.style.display = totalQty ? '' : 'none';
    badge.textContent   = totalQty;
    document.getElementById('btnClr').style.display = totalQty ? 'flex' : 'none';
    document.getElementById('btnPay').disabled      = !totalQty;
    document.getElementById('emptyState').style.display = totalQty ? 'none' : '';

    var list = document.getElementById('cartList');
    if (!totalQty) { list.innerHTML = ''; return; }

    list.innerHTML = items.map(function(item, idx) {
      return '<div class="ci">'
        + '<div class="ci-num">' + (idx+1) + '</div>'
        + '<div class="ci-info">'
        + '<div class="ci-name">' + item.name + '</div>'
        + '<div class="ci-price">' + rp(item.price) + ' / pcs</div>'
        + '</div>'
        + '<div class="ci-right">'
        + '<div class="ci-sub">' + rp(item.price * item.qty) + '</div>'
        + '<div class="qc">'
        + '<button class="qb" data-cid="' + item.id + '" data-d="-1">-</button>'
        + '<span class="qn">' + item.qty + '</span>'
        + '<button class="qb" data-cid="' + item.id + '" data-d="1">+</button>'
        + '</div></div></div>';
    }).join('');
  }

  /* Cart qty delegation */
  document.getElementById('cartList').addEventListener('click', function(e) {
    var btn = e.target.closest('.qb[data-cid]');
    if (!btn) return;
    e.stopPropagation();
    changeQty(Number(btn.dataset.cid), Number(btn.dataset.d));
  });

  /* Summary */
  function getSubtotal() { return Object.values(cart).reduce(function(s,i){ return s + i.price * i.qty; }, 0); }
  function getDiscount()  { return Math.max(0, Number(document.getElementById('elDiscount').value) || 0); }
  function getTotal()     { return Math.max(0, getSubtotal() - getDiscount()); }

  function updateSummary() {
    document.getElementById('elSubtotal').textContent = rp(getSubtotal());
    document.getElementById('elTotal').textContent    = rp(getTotal());
  }

  /* Payment */
  function openPayment() {
    var total = getTotal();
    var count = Object.values(cart).reduce(function(s,i){ return s + i.qty; }, 0);
    document.getElementById('mTotal').textContent   = rp(total);
    document.getElementById('mCount').textContent   = count + ' item';
    document.getElementById('paidInp').value        = '';
    document.getElementById('elChange').textContent = rp(0);
    document.getElementById('btnConfirm').disabled  = true;

    var opts = [];
    var seen = {};
    [total, Math.ceil(total/5000)*5000, Math.ceil(total/10000)*10000, Math.ceil(total/50000)*50000].forEach(function(v) {
      if (v >= total && !seen[v]) { opts.push(v); seen[v] = true; }
    });
    opts = opts.slice(0, 5);
    document.getElementById('quickBtns').innerHTML = opts.map(function(v) {
      return '<button data-v="' + v + '">' + rp(v) + '</button>';
    }).join('');

    setPayMethod('cash');
    document.getElementById('payOverlay').classList.add('show');
    setTimeout(function(){ document.getElementById('paidInp').focus(); }, 250);
  }

  function closePayment() { document.getElementById('payOverlay').classList.remove('show'); }

  function setPayMethod(m) {
    payMethod = m;
    document.querySelectorAll('.meth').forEach(function(b) {
      b.classList.toggle('on', b.dataset.m === m);
    });
    document.getElementById('cashSec').style.display    = m === 'cash' ? '' : 'none';
    document.getElementById('noncashSec').style.display = m !== 'cash' ? '' : 'none';

    var qrisPanel = document.getElementById('qrisPanel');
    var modalBox  = document.getElementById('payModalBox');

    if (m !== 'cash') {
      document.getElementById('btnConfirm').disabled = false;
      // Tampilkan panel QRIS dan perlebar modal
      qrisPanel.style.display = '';
      modalBox.style.width    = '740px';
      // Update total
      var totalVal = getTotal();
      var qrisEl = document.querySelector('.qris-total-val');
      if (qrisEl) qrisEl.textContent = rp(totalVal);
      // Generate QR code
      var canvas = document.getElementById('qrisCanvas');
      if (canvas) {
        canvas.innerHTML = '';
        var qrData = 'https://qris.id/payment/tehkota?amount=' + Math.round(totalVal);
        qrInstance = new QRCode(canvas, {
          text: qrData,
          width: 220,
          height: 220,
          colorDark: '#111111',
          colorLight: '#ffffff',
          correctLevel: QRCode.CorrectLevel.M,
        });
      }
    } else {
      // Sembunyikan panel QRIS dan kembalikan ukuran modal
      qrisPanel.style.display = 'none';
      modalBox.style.width    = '440px';
      calcChange();
    }
  }

  function calcChange() {
    var total = getTotal();
    var paid  = Number(document.getElementById('paidInp').value) || 0;
    document.getElementById('elChange').textContent = rp(Math.max(0, paid - total));
    document.getElementById('btnConfirm').disabled  = paid < total;
  }

  async function processPayment() {
    var total = getTotal();
    var paid  = payMethod === 'cash' ? Number(document.getElementById('paidInp').value) || 0 : total;
    if (payMethod === 'cash' && paid < total) { toast('Jumlah uang kurang'); return; }

    var btn = document.getElementById('btnConfirm');
    btn.disabled = true; btn.textContent = 'Memproses...';

    try {
      var res = await fetch('{{ route("pos.checkout") }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
        body: JSON.stringify({
          items:          Object.values(cart).map(function(i){ return { id: i.id, qty: i.qty }; }),
          payment_method: payMethod,
          payment_amount: paid,
          discount:       getDiscount(),
          customer_name:  document.getElementById('custName').value.trim(),
        }),
      });
      var data = await res.json();
      if (data.success) {
        closePayment();
        document.getElementById('sInv').textContent = data.invoice_number;
        document.getElementById('sChg').textContent = payMethod === 'cash' ? 'Kembalian ' + rp(data.change) : 'Lunas';
        document.getElementById('sPrint').href = '/transactions/' + data.transaction_id + '/print';
        document.getElementById('okOverlay').classList.add('show');
      } else {
        toast(data.message || 'Terjadi kesalahan');
      }
    } catch(err) { toast('Terjadi kesalahan. Coba lagi.'); }
    finally { btn.disabled = false; btn.textContent = 'Konfirmasi'; }
  }

  /* Event Bindings */
  document.querySelectorAll('.cat-btn').forEach(function(btn) {
    btn.addEventListener('click', function() {
      document.querySelectorAll('.cat-btn').forEach(function(b){ b.classList.remove('on'); });
      this.classList.add('on');
      curCat = this.dataset.cat;
      loadProducts();
    });
  });

  var st;
  document.getElementById('srch').addEventListener('input', function() { clearTimeout(st); st = setTimeout(loadProducts, 280); });
  document.getElementById('elDiscount').addEventListener('input', updateSummary);
  document.getElementById('btnClr').addEventListener('click', clearCart);
  document.getElementById('btnPay').addEventListener('click', openPayment);
  document.getElementById('btnClosePay').addEventListener('click', closePayment);
  document.getElementById('btnCancelPay').addEventListener('click', closePayment);
  document.getElementById('payOverlay').addEventListener('click', function(e) { if (e.target === e.currentTarget) closePayment(); });
  document.querySelectorAll('.meth').forEach(function(btn) {
    btn.addEventListener('click', function() { setPayMethod(this.dataset.m); });
  });
  document.getElementById('paidInp').addEventListener('input', calcChange);
  document.getElementById('quickBtns').addEventListener('click', function(e) {
    var b = e.target.closest('button[data-v]');
    if (!b) return;
    document.getElementById('paidInp').value = b.dataset.v;
    calcChange();
  });
  document.getElementById('btnConfirm').addEventListener('click', processPayment);
  document.getElementById('btnNew').addEventListener('click', function() {
    document.getElementById('okOverlay').classList.remove('show');
    clearCart();
    document.getElementById('elDiscount').value = 0;
    document.getElementById('custName').value   = '';
    updateSummary();
    loadProducts();
  });

  /* ── Mobile cart toggle ── */
  window.toggleCartMobile = function() {
    var panel   = document.querySelector('.cart-panel');
    var overlay = document.getElementById('cartOverlay');
    var isOpen  = panel.classList.contains('show');
    if (isOpen) {
      panel.classList.remove('show');
      overlay.classList.remove('show');
      document.body.style.overflow = '';
    } else {
      panel.classList.add('show');
      overlay.classList.add('show');
      document.body.style.overflow = 'hidden';
    }
  };

  /* Sync FAB badge dengan cart badge */
  var origRenderCart = renderCart;
  renderCart = function() {
    origRenderCart();
    var total = Object.values(cart).reduce(function(s,i){ return s + i.qty; }, 0);
    var fab   = document.getElementById('cartFab');
    var fb    = document.getElementById('fabBadge');
    if (fab) {
      fab.style.background = total ? 'var(--tea)' : '#9ca3af';
    }
    if (fb) {
      fb.textContent = total;
      fb.classList.toggle('show', total > 0);
    }
  };

  /* Category tabs mobile sync */
  document.querySelectorAll('.cat-tab-pill').forEach(function(btn) {
    btn.addEventListener('click', function() {
      document.querySelectorAll('.cat-tab-pill').forEach(function(b){ b.classList.remove('on'); });
      this.classList.add('on');
      // Sync dengan sidebar
      document.querySelectorAll('.cat-btn').forEach(function(b){ b.classList.remove('on'); });
      var sideBtn = document.querySelector('.cat-btn[data-cat="'+this.dataset.cat+'"]');
      if (sideBtn) sideBtn.classList.add('on');
      curCat = this.dataset.cat;
      loadProducts();
    });
  });

  /* ── Theme toggle ── */
  window.toggleTheme = function() {
    var html = document.documentElement;
    var ico  = document.getElementById('themeIco');
    if (html.getAttribute('data-theme') === 'dark') {
      html.removeAttribute('data-theme');
      ico.className = 'bi bi-moon-fill';
      localStorage.setItem('pos-theme', 'light');
    } else {
      html.setAttribute('data-theme', 'dark');
      ico.className = 'bi bi-sun-fill';
      localStorage.setItem('pos-theme', 'dark');
    }
  };

  /* Restore theme dari localStorage */
  (function() {
    if (localStorage.getItem('pos-theme') === 'dark') {
      document.documentElement.setAttribute('data-theme', 'dark');
      var ico = document.getElementById('themeIco');
      if (ico) ico.className = 'bi bi-sun-fill';
    }
  })();

  loadProducts();
})();
</script>
</body>
</html>

