from PIL import Image, ImageDraw, ImageFont
import os

os.makedirs('docs', exist_ok=True)

try:
    font_bold = ImageFont.truetype('arialbd.ttf', 15)
    font_reg = ImageFont.truetype('arial.ttf', 12)
    font_sm = ImageFont.truetype('arial.ttf', 10)
    font_title = ImageFont.truetype('arialbd.ttf', 18)
except:
    font_bold = font_reg = font_sm = font_title = ImageFont.load_default()

# 1. WIREFRAME KASIR POS (Hitam Putih)
w, h = 900, 560
wf1 = Image.new('RGB', (w, h), color=(255, 255, 255))
d1 = ImageDraw.Draw(wf1)

# Outer frame
d1.rectangle([10, 10, w-10, h-10], outline=(0,0,0), width=2)
# Header bar
d1.rectangle([10, 10, w-10, 55], outline=(0,0,0), width=1, fill=(245,245,245))
d1.text((30, 25), "[LOGO] CAFE RJ - TERMINAL KASIR", fill=(0,0,0), font=font_bold)
d1.rectangle([650, 20, 870, 45], outline=(0,0,0), width=1)
d1.text((660, 26), "Kasir: [Nama Kasir] | [Logout]", fill=(0,0,0), font=font_sm)

# Left area (Catalog) width: 570
# Category bar
d1.text((30, 70), "KATEGORI:", fill=(0,0,0), font=font_bold)
cats = ["[ Semua Menu ]", "[ Kopi ]", "[ Non-Kopi ]", "[ Makanan ]"]
cx = 120
for cat in cats:
    d1.rectangle([cx, 65, cx+95, 90], outline=(0,0,0), width=1)
    d1.text((cx+10, 72), cat, fill=(0,0,0), font=font_sm)
    cx += 105

# Product grid (3 cols x 2 rows)
px_start, py_start = 30, 105
for r in range(2):
    for c in range(3):
        x = px_start + c * 175
        y = py_start + r * 195
        d1.rectangle([x, y, x+160, y+180], outline=(0,0,0), width=1, fill=(250,250,250))
        # Image placeholder box with X
        d1.rectangle([x+10, y+10, x+150, y+110], outline=(150,150,150), width=1)
        d1.line([(x+10, y+10), (x+150, y+110)], fill=(200,200,200), width=1)
        d1.line([(x+10, y+110), (x+150, y+10)], fill=(200,200,200), width=1)
        d1.text((x+50, y+50), "[ FOTO ]", fill=(100,100,100), font=font_sm)
        # Info
        d1.text((x+15, y+120), f"Nama Menu #{r*3+c+1}", fill=(0,0,0), font=font_bold)
        d1.text((x+15, y+140), "Rp 20.000 | Stok: 15", fill=(80,80,80), font=font_sm)
        d1.rectangle([x+15, y+158, x+145, y+175], outline=(0,0,0), width=1)
        d1.text((x+45, y+161), "+ Tambah", fill=(0,0,0), font=font_sm)

# Right area (Cart & Checkout) from x=580 to 880
d1.line([(580, 55), (580, h-10)], fill=(0,0,0), width=2)
d1.rectangle([580, 55, w-10, 95], outline=(0,0,0), width=1, fill=(245,245,245))
d1.text((600, 68), "KERANJANG PESANAN", fill=(0,0,0), font=font_bold)

# Cart Items
cart_y = 110
for i in range(3):
    d1.rectangle([595, cart_y, 875, cart_y+45], outline=(180,180,180), width=1)
    d1.text((605, cart_y+8), f"Menu Pesanan #{i+1}", fill=(0,0,0), font=font_bold)
    d1.text((605, cart_y+26), "1x @ Rp 20.000", fill=(100,100,100), font=font_sm)
    d1.rectangle([780, cart_y+10, 805, cart_y+35], outline=(0,0,0), width=1)
    d1.text((788, cart_y+13), "-", fill=(0,0,0), font=font_bold)
    d1.text((818, cart_y+15), "1", fill=(0,0,0), font=font_sm)
    d1.rectangle([835, cart_y+10, 860, cart_y+35], outline=(0,0,0), width=1)
    d1.text((843, cart_y+13), "+", fill=(0,0,0), font=font_bold)
    cart_y += 55

# Subtotal & Payment section
d1.line([(580, 290), (w-10, 290)], fill=(0,0,0), width=1)
d1.text((600, 305), "Total Belanja:", fill=(0,0,0), font=font_bold)
d1.text((780, 305), "Rp 60.000", fill=(0,0,0), font=font_bold)

# Payment method tabs
d1.text((600, 335), "Metode Pembayaran:", fill=(80,80,80), font=font_sm)
d1.rectangle([600, 355, 680, 385], outline=(0,0,0), width=2, fill=(230,230,230))
d1.text((620, 363), "Tunai", fill=(0,0,0), font=font_bold)
d1.rectangle([690, 355, 770, 385], outline=(150,150,150), width=1)
d1.text((715, 363), "QRIS", fill=(80,80,80), font=font_sm)
d1.rectangle([780, 355, 860, 385], outline=(150,150,150), width=1)
d1.text((795, 363), "Transfer", fill=(80,80,80), font=font_sm)

# Cash input & kembalian box
d1.rectangle([600, 400, 860, 440], outline=(0,0,0), width=1)
d1.text((610, 407), "Uang Diterima: [ Rp 100.000 ]", fill=(0,0,0), font=font_sm)
d1.text((610, 423), "Uang Kembalian: Rp 40.000", fill=(0,0,0), font=font_bold)

# Big button
d1.rectangle([600, 465, 860, 520], outline=(0,0,0), width=2, fill=(24,24,27))
d1.text((630, 485), "[ BAYAR & CETAK STRUK ]", fill=(255,255,255), font=font_bold)

wf1.save('docs/wireframe_kasir_pos.png')
print('wireframe_kasir_pos.png generated')

# 2. WIREFRAME ADMIN DASHBOARD (Hitam Putih)
wf2 = Image.new('RGB', (w, h), color=(255, 255, 255))
d2 = ImageDraw.Draw(wf2)
d2.rectangle([10, 10, w-10, h-10], outline=(0,0,0), width=2)
# Header
d2.rectangle([10, 10, w-10, 55], outline=(0,0,0), width=1, fill=(245,245,245))
d2.text((30, 25), "[LOGO] CAFE RJ - PANEL ADMINISTRATOR", fill=(0,0,0), font=font_bold)
d2.text((700, 25), "Admin: [Owner] | [Logout]", fill=(0,0,0), font=font_sm)

# Sidebar (width 200)
d2.line([(210, 55), (210, h-10)], fill=(0,0,0), width=2)
navs = ["> Dashboard", "> Manajemen Menu", "> Kategori Menu", "> Akun Kasir", "> Riwayat Transaksi", "> Laporan Omzet"]
ny = 75
for nav in navs:
    d2.rectangle([25, ny, 195, ny+32], outline=(150,150,150), width=1)
    d2.text((35, ny+8), nav, fill=(0,0,0), font=font_sm)
    ny += 42

# Main content area
d2.text((235, 75), "DASHBOARD DAN REKAPITULASI PENJUALAN", fill=(0,0,0), font=font_bold)

# 4 Metric Cards
mx = 235
m_titles = [("Total Omzet Hari Ini", "Rp 1.450.000"), ("Total Transaksi", "42 Struk"), ("Menu Terlaris", "Es Kopi Susu RJ"), ("Peringatan Stok", "3 Menu Menipis")]
for title, val in m_titles:
    d2.rectangle([mx, 105, mx+150, 175], outline=(0,0,0), width=1, fill=(250,250,250))
    d2.text((mx+10, 115), title, fill=(80,80,80), font=font_sm)
    d2.text((mx+10, 140), val, fill=(0,0,0), font=font_bold)
    mx += 160

# Table Section
d2.text((235, 200), "TABEL MASTER DATA MENU PRODUK", fill=(0,0,0), font=font_bold)
d2.rectangle([730, 195, 865, 225], outline=(0,0,0), width=1, fill=(230,230,230))
d2.text((745, 203), "+ Tambah Menu", fill=(0,0,0), font=font_sm)

# Table Header
d2.rectangle([235, 235, 865, 265], outline=(0,0,0), width=1, fill=(240,240,240))
d2.text((245, 243), "No", fill=(0,0,0), font=font_bold)
d2.text((280, 243), "Foto", fill=(0,0,0), font=font_bold)
d2.text((350, 243), "Nama Menu", fill=(0,0,0), font=font_bold)
d2.text((500, 243), "Kategori", fill=(0,0,0), font=font_bold)
d2.text((600, 243), "Harga", fill=(0,0,0), font=font_bold)
d2.text((690, 243), "Stok", fill=(0,0,0), font=font_bold)
d2.text((760, 243), "Aksi", fill=(0,0,0), font=font_bold)

# Table Rows
ty = 265
rows = [
    ("1", "[Foto]", "Es Kopi Susu RJ", "Kopi", "Rp 22.000", "35", "[Edit] [Hapus]"),
    ("2", "[Foto]", "Americano", "Kopi", "Rp 18.000", "20", "[Edit] [Hapus]"),
    ("3", "[Foto]", "Matcha Latte", "Non-Kopi", "Rp 25.000", "12", "[Edit] [Hapus]"),
    ("4", "[Foto]", "Croissant Almond", "Makanan", "Rp 30.000", "8", "[Edit] [Hapus]"),
    ("5", "[Foto]", "French Fries RJ", "Makanan", "Rp 20.000", "15", "[Edit] [Hapus]")
]
for r in rows:
    d2.rectangle([235, ty, 865, ty+45], outline=(200,200,200), width=1)
    d2.text((245, ty+14), r[0], fill=(0,0,0), font=font_sm)
    d2.rectangle([280, ty+6, 320, ty+38], outline=(150,150,150), width=1)
    d2.text((286, ty+15), "Img", fill=(100,100,100), font=font_sm)
    d2.text((350, ty+14), r[2], fill=(0,0,0), font=font_bold)
    d2.text((500, ty+14), r[3], fill=(0,0,0), font=font_sm)
    d2.text((600, ty+14), r[4], fill=(0,0,0), font=font_sm)
    d2.text((695, ty+14), r[5], fill=(0,0,0), font=font_sm)
    d2.text((760, ty+14), r[6], fill=(0,0,0), font=font_sm)
    ty += 45

wf2.save('docs/wireframe_admin_dashboard.png')
print('wireframe_admin_dashboard.png generated')

# 3. WIREFRAME MODAL PEMBAYARAN / QRIS (Hitam Putih)
wf3 = Image.new('RGB', (w, h), color=(255, 255, 255))
d3 = ImageDraw.Draw(wf3)
d3.rectangle([10, 10, w-10, h-10], outline=(0,0,0), width=2)
d3.rectangle([10, 10, w-10, 55], outline=(0,0,0), width=1, fill=(245,245,245))
d3.text((30, 25), "[LOGO] CAFE RJ - WIREFRAME MODAL TRANSAKSI", fill=(0,0,0), font=font_bold)

# Centered Modal Dialog Box
mx1, my1, mx2, my2 = 250, 90, 650, 510
# Backdrop shadow
d3.rectangle([mx1+4, my1+4, mx2+4, my2+4], fill=(220,220,220))
d3.rectangle([mx1, my1, mx2, my2], outline=(0,0,0), width=2, fill=(255,255,255))

# Modal Header
d3.rectangle([mx1, my1, mx2, my1+45], outline=(0,0,0), width=1, fill=(245,245,245))
d3.text((mx1+20, my1+15), "LAYAR PEMBAYARAN QRIS PELANGGAN", fill=(0,0,0), font=font_bold)
d3.rectangle([mx2-35, my1+10, mx2-10, my1+35], outline=(0,0,0), width=1)
d3.text((mx2-27, my1+13), "X", fill=(0,0,0), font=font_bold)

# Merchant Info
d3.text((mx1+80, my1+65), "MERCHANT RESMI: CAFE RJ", fill=(0,0,0), font=font_bold)
d3.text((mx1+100, my1+85), "NMID: ID1020260909001", fill=(80,80,80), font=font_sm)

# QR Code Frame Box
d3.rectangle([mx1+100, my1+110, mx1+300, my1+310], outline=(0,0,0), width=2, fill=(250,250,250))
d3.line([(mx1+100, my1+110), (mx1+300, my1+310)], fill=(200,200,200), width=1)
d3.line([(mx1+100, my1+310), (mx1+300, my1+110)], fill=(200,200,200), width=1)
d3.text((mx1+155, my1+200), "[ KODE QRIS ]", fill=(0,0,0), font=font_bold)

# Total Box
d3.rectangle([mx1+50, my1+325, mx2-50, my1+375], outline=(0,0,0), width=1, fill=(245,245,245))
d3.text((mx1+80, my1+335), "TOTAL TAGIHAN PEMBAYARAN:", fill=(80,80,80), font=font_sm)
d3.text((mx1+130, my1+352), "Rp 60.000", fill=(0,0,0), font=font_bold)

# Supported E-Wallets text
d3.text((mx1+40, my1+390), "Mendukung: GoPay, OVO, DANA, BCA, Mandiri, dll.", fill=(100,100,100), font=font_sm)

# Action button
d3.rectangle([mx1+80, my1+420, mx2-80, my1+465], outline=(0,0,0), width=2, fill=(24,24,27))
d3.text((mx1+130, my1+435), "[ KEMBALI KE KASIR ]", fill=(255,255,255), font=font_bold)

wf3.save('docs/wireframe_pembayaran_qris.png')
print('wireframe_pembayaran_qris.png generated')
