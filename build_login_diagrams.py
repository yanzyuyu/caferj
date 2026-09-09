from PIL import Image, ImageDraw, ImageFont
import shutil
import os

os.makedirs('docs', exist_ok=True)

# Copy uploaded login screenshot to docs
src_login = r"C:\Users\MSI\.gemini\antigravity\brain\c3036775-bc1f-4eb0-84c0-b79c145f17a0\.user_uploaded\media_1788926549303.png"
if os.path.exists(src_login):
    shutil.copy(src_login, "docs/login_web_screen.png")
    print("Copied user login screenshot to docs/login_web_screen.png")

# Generate Wireframe Login (Hitam Putih)
w, h = 900, 560
wf_log = Image.new('RGB', (w, h), color=(255, 255, 255))
d = ImageDraw.Draw(wf_log)

try:
    font_bold = ImageFont.truetype('arialbd.ttf', 16)
    font_reg = ImageFont.truetype('arial.ttf', 12)
    font_sm = ImageFont.truetype('arial.ttf', 10)
    font_title = ImageFont.truetype('arialbd.ttf', 22)
except:
    font_bold = font_reg = font_sm = font_title = ImageFont.load_default()

# Outer browser frame
d.rectangle([10, 10, w-10, h-10], outline=(0,0,0), width=2)
# Browser bar
d.rectangle([10, 10, w-10, 45], outline=(0,0,0), width=1, fill=(245,245,245))
d.text((30, 20), "http://127.0.0.1:8000/login - [WIREFRAME HALAMAN LOGIN]", fill=(50,50,50), font=font_sm)

cx = w // 2

# Title & subtitle
d.text((cx, 110), "Cafe RJ", fill=(0,0,0), font=font_title, anchor='mm')
d.text((cx, 135), "Point of Sale System", fill=(80,80,80), font=font_reg, anchor='mm')

# Centered Login Box
bx1, by1, bx2, by2 = cx - 180, 165, cx + 180, 420
d.rectangle([bx1, by1, bx2, by2], outline=(0,0,0), width=2, fill=(255,255,255))

# Email field
d.text((bx1 + 25, by1 + 25), "Email", fill=(0,0,0), font=font_bold)
d.rectangle([bx1 + 25, by1 + 48, bx2 - 25, by1 + 88], outline=(150,150,150), width=1, fill=(250,250,250))
d.text((bx1 + 38, by1 + 60), "admin@caferj.local", fill=(80,80,80), font=font_reg)

# Password field
d.text((bx1 + 25, by1 + 105), "Password", fill=(0,0,0), font=font_bold)
d.rectangle([bx1 + 25, by1 + 128, bx2 - 25, by1 + 168], outline=(150,150,150), width=1, fill=(250,250,250))
d.text((bx1 + 38, by1 + 140), "● ● ● ● ● ● ● ●", fill=(80,80,80), font=font_reg)

# Masuk Button
d.rectangle([bx1 + 25, by1 + 190, bx2 - 25, by1 + 230], outline=(0,0,0), width=1, fill=(24,24,27))
d.text((cx, by1 + 210), "Masuk", fill=(255,255,255), font=font_bold, anchor='mm')

# Footer
d.text((cx, 455), "Cafe RJ © 2026", fill=(100,100,100), font=font_sm, anchor='mm')

wf_log.save("docs/wireframe_login.png")
print("wireframe_login.png generated successfully")
