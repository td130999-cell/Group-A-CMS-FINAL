import urllib.request
import os

images = {
    "guatemala_alma_main.jpg": "https://cdn.shopify.com/s/files/1/2554/7062/files/DSC05208.jpg",
    "guatemala_alma_label.png": "https://cdn.shopify.com/s/files/1/2554/7062/files/AlmaCoffeeLabel.png",
    "guatemala_alma_farm.jpg": "https://cdn.shopify.com/s/files/1/2554/7062/files/13DB14F3-47B4-420F-8A56-B42C84419ACB.jpg",
    "colombia_paraiso_main.jpg": "https://cdn.shopify.com/s/files/1/2554/7062/files/DSC05126.jpg",
    "colombia_paraiso_feat.jpg": "https://cdn.shopify.com/s/files/1/2554/7062/files/paraisoproductFeatured.jpg",
    "blacksmith_main.jpg": "https://cdn.shopify.com/s/files/1/2554/7062/files/Blacksmith_product_photo.jpg",
    "blacksmith_back.jpg": "https://cdn.shopify.com/s/files/1/2554/7062/files/Bag_back_product_photo_330c0f3d-9888-4609-8d82-a4a80ef09f60.jpg",
    "inkwell_main.jpg": "https://cdn.shopify.com/s/files/1/2554/7062/files/Inkwell_product_photo.jpg",
    "night_owl_main.jpg": "https://cdn.shopify.com/s/files/1/2554/7062/files/Night_Owl_product_photo.jpg",
    "ethiopia_bombe_main.jpg": "https://cdn.shopify.com/s/files/1/2554/7062/files/DSC02922.jpg",
    "ethiopia_bombe_label.png": "https://cdn.shopify.com/s/files/1/2554/7062/files/Bombe_Coffee_Label.png",
    "kenya_embu_main.jpg": "https://cdn.shopify.com/s/files/1/2554/7062/files/DSC04685.jpg",
    "kenya_embu_label.png": "https://cdn.shopify.com/s/files/1/2554/7062/files/Embu_AA_Coffee_Label.png",
    "southern_gothic_main.jpg": "https://cdn.shopify.com/s/files/1/2554/7062/files/Southern_Gothic_glass.jpg",
    "quills_logo.png": "https://quillscoffee.com/cdn/shop/files/quills_logo_horizontal_black_200x.png"
}

out_dir = os.path.join("wp-content", "uploads", "quills")
os.makedirs(out_dir, exist_ok=True)

headers = {'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)'}

for fname, url in images.items():
    fpath = os.path.join(out_dir, fname)
    if os.path.exists(fpath) and os.path.getsize(fpath) > 1000:
        print(f"Already exists: {fname}")
        continue
    print(f"Downloading {fname} from {url}...")
    try:
        req = urllib.request.Request(url, headers=headers)
        with urllib.request.urlopen(req, timeout=20) as resp:
            with open(fpath, "wb") as f:
                f.write(resp.read())
        print(f"Saved {fname} ({os.path.getsize(fpath)} bytes)")
    except Exception as e:
        print(f"Failed {fname}: {e}")

print("All downloads finished.")
