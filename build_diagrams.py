from PIL import Image, ImageDraw, ImageFont
import os

os.makedirs('docs', exist_ok=True)

# 1. ACTIVITY DIAGRAM
w, h = 900, 1080
img = Image.new('RGB', (w, h), color=(255, 255, 255))
draw = ImageDraw.Draw(img)

try:
    font_bold = ImageFont.truetype('arialbd.ttf', 16)
    font_reg = ImageFont.truetype('arial.ttf', 14)
    font_sm = ImageFont.truetype('arial.ttf', 12)
    font_title = ImageFont.truetype('arialbd.ttf', 20)
except:
    font_bold = font_reg = font_sm = font_title = ImageFont.load_default()

draw.text((w//2, 35), 'ACTIVITY DIAGRAM: TRANSAKSI KASIR POS CAFE RJ', fill=(0,0,0), font=font_title, anchor='mm')
draw.line([(50, 60), (w-50, 60)], fill=(200,200,200), width=1)

def draw_pill(text, x, y, rw=140, rh=36, fill=(24,24,27), text_fill=(255,255,255)):
    draw.rounded_rectangle([x - rw//2, y - rh//2, x + rw//2, y + rh//2], radius=18, fill=fill, outline=(0,0,0), width=2)
    draw.text((x, y), text, fill=text_fill, font=font_bold, anchor='mm')

def draw_box(text, x, y, rw=320, rh=46, fill=(255,255,255), outline=(39,39,42)):
    draw.rounded_rectangle([x - rw//2, y - rh//2, x + rw//2, y + rh//2], radius=8, fill=fill, outline=outline, width=2)
    draw.text((x, y), text, fill=(0,0,0), font=font_reg, anchor='mm')

def draw_diamond(text, x, y, size=40, fill=(244,244,245), outline=(39,39,42)):
    pts = [(x, y - size), (x + size*1.5, y), (x, y + size), (x - size*1.5, y)]
    draw.polygon(pts, fill=fill, outline=outline, width=2)
    draw.text((x, y), text, fill=(0,0,0), font=font_bold, anchor='mm')

def draw_arrow(x1, y1, x2, y2, label=''):
    draw.line([(x1, y1), (x2, y2)], fill=(50,50,50), width=2)
    if y2 > y1:
        draw.polygon([(x2, y2), (x2-5, y2-8), (x2+5, y2-8)], fill=(50,50,50))
    elif x2 > x1:
        draw.polygon([(x2, y2), (x2-8, y2-5), (x2-8, y2+5)], fill=(50,50,50))
    elif x2 < x1:
        draw.polygon([(x2, y2), (x2+8, y2-5), (x2+8, y2+5)], fill=(50,50,50))
    if label:
        lx = (x1 + x2)//2 + 8
        ly = (y1 + y2)//2 - 10
        draw.text((lx, ly), label, fill=(30,30,30), font=font_sm)

cx = w // 2

draw_pill('Mulai', cx, 95)
draw_arrow(cx, 113, cx, 145)

draw_box('1. Kasir Membuka Terminal POS Kasir', cx, 168)
draw_arrow(cx, 191, cx, 220)

draw_box('2. Pilih Kategori dan Klik Menu Produk', cx, 243)
draw_arrow(cx, 266, cx, 295)

draw_box('3. Menu Masuk Keranjang dan Hitung Total', cx, 318)
draw_arrow(cx, 341, cx, 385)

draw_diamond('Metode Bayar?', cx, 435, size=40)

# Tunai
draw_arrow(cx - 60, 435, 180, 435, 'Tunai')
draw_arrow(180, 435, 180, 490)
draw_box('Input Uang Tunai Diterima', 180, 515, rw=210, rh=44)
draw_arrow(180, 537, 180, 580)
draw_box('Hitung Uang Kembalian Otomatis', 180, 602, rw=220, rh=44)
draw_arrow(180, 624, 180, 680)
draw.line([(180, 680), (cx, 680)], fill=(50,50,50), width=2)

# QRIS
draw_arrow(cx, 475, cx, 580, 'QRIS')
draw_box('Tampilkan Standee QR Code Dinamis', cx, 602, rw=240, rh=44)
draw_arrow(cx, 624, cx, 680)

# Transfer
draw_arrow(cx + 60, 435, 720, 435, 'Transfer')
draw_arrow(720, 435, 720, 580)
draw_box('Tampilkan Rekening Bank (BCA/Mandiri/BRI)', 720, 602, rw=280, rh=44)
draw_arrow(720, 624, 720, 680)
draw.line([(720, 680), (cx, 680)], fill=(50,50,50), width=2)

# Merge
draw_arrow(cx, 680, cx, 725)
draw_box('4. Kasir Klik Tombol Bayar dan Cetak Struk', cx, 748, rw=320)
draw_arrow(cx, 771, cx, 805)

draw_box('5. Sistem Simpan Transaksi ke Database dan Potong Stok', cx, 828, rw=380)
draw_arrow(cx, 851, cx, 885)

draw_box('6. Muncul Dialog Cetak Struk (Faktur A4 / Thermal 80mm)', cx, 908, rw=380)
draw_arrow(cx, 931, cx, 970)

draw_pill('Selesai', cx, 990, fill=(24,24,27))

img.save('docs/activity_diagram.png')
print('activity_diagram.png created')

# 2. DFD LEVEL 0
w, h = 900, 560
dfd_img = Image.new('RGB', (w, h), color=(255, 255, 255))
draw_dfd = ImageDraw.Draw(dfd_img)

draw_dfd.text((w//2, 35), 'DATA FLOW DIAGRAM (DFD) KONTEKS LEVEL 0', fill=(0,0,0), font=font_title, anchor='mm')
draw_dfd.line([(50, 60), (w-50, 60)], fill=(200,200,200), width=1)

# Left: Kasir
draw_dfd.rectangle([50, 180, 200, 260], fill=(245,245,245), outline=(0,0,0), width=2)
draw_dfd.text((125, 205), 'KASIR', fill=(0,0,0), font=font_bold, anchor='mm')
draw_dfd.text((125, 230), '(External Entity)', fill=(80,80,80), font=font_sm, anchor='mm')

# Center: Sistem POS
draw_dfd.ellipse([340, 140, 560, 300], fill=(24,24,27), outline=(0,0,0), width=2)
draw_dfd.text((450, 205), 'SISTEM POS', fill=(255,255,255), font=font_bold, anchor='mm')
draw_dfd.text((450, 235), 'CAFE RJ', fill=(255,255,255), font=font_bold, anchor='mm')
draw_dfd.text((450, 260), '(Level 0)', fill=(200,200,200), font=font_sm, anchor='mm')

# Right: Admin
draw_dfd.rectangle([700, 180, 850, 260], fill=(245,245,245), outline=(0,0,0), width=2)
draw_dfd.text((775, 205), 'ADMIN', fill=(0,0,0), font=font_bold, anchor='mm')
draw_dfd.text((775, 230), '(External Entity)', fill=(80,80,80), font=font_sm, anchor='mm')

# Bottom: Database
draw_dfd.rounded_rectangle([320, 420, 580, 490], radius=10, fill=(240,240,245), outline=(0,0,0), width=2)
draw_dfd.text((450, 445), 'DATABASE MYSQL', fill=(0,0,0), font=font_bold, anchor='mm')
draw_dfd.text((450, 470), '(Tabel caferj)', fill=(80,80,80), font=font_sm, anchor='mm')

# Flows Kasir -> Sistem
draw_dfd.line([(200, 205), (340, 205)], fill=(0,0,0), width=2)
draw_dfd.polygon([(340, 205), (332, 201), (332, 209)], fill=(0,0,0))
draw_dfd.text((270, 190), 'Data Pesanan & Bayar', fill=(0,0,0), font=font_sm, anchor='mm')

draw_dfd.line([(340, 235), (200, 235)], fill=(0,0,0), width=2)
draw_dfd.polygon([(200, 235), (208, 231), (208, 239)], fill=(0,0,0))
draw_dfd.text((270, 250), 'Tampilan Menu & Struk', fill=(0,0,0), font=font_sm, anchor='mm')

# Flows Admin -> Sistem
draw_dfd.line([(700, 205), (560, 205)], fill=(0,0,0), width=2)
draw_dfd.polygon([(560, 205), (568, 201), (568, 209)], fill=(0,0,0))
draw_dfd.text((630, 190), 'Master Data & Filter', fill=(0,0,0), font=font_sm, anchor='mm')

draw_dfd.line([(560, 235), (700, 235)], fill=(0,0,0), width=2)
draw_dfd.polygon([(700, 235), (692, 231), (692, 239)], fill=(0,0,0))
draw_dfd.text((630, 250), 'Dashboard & Laporan', fill=(0,0,0), font=font_sm, anchor='mm')

# Flows Sistem <-> DB
draw_dfd.line([(430, 300), (430, 420)], fill=(0,0,0), width=2)
draw_dfd.polygon([(430, 420), (426, 412), (434, 412)], fill=(0,0,0))
draw_dfd.text((360, 360), 'Simpan Transaksi', fill=(0,0,0), font=font_sm, anchor='mm')

draw_dfd.line([(470, 420), (470, 300)], fill=(0,0,0), width=2)
draw_dfd.polygon([(470, 300), (466, 308), (474, 308)], fill=(0,0,0))
draw_dfd.text((540, 360), 'Baca Menu & Stok', fill=(0,0,0), font=font_sm, anchor='mm')

dfd_img.save('docs/dfd_level_0.png')
print('dfd_level_0.png created')
