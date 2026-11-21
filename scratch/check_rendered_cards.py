import re

with open('d:/Group-A-CMS-FINAL/scratch_coffee_rendered.html', encoding='utf-8') as f:
    html = f.read()

cards = re.findall(r'<article class="quills-coffee-card".*?</article>', html, re.DOTALL)
print(f"Total cards rendered: {len(cards)}")

for i, card in enumerate(cards[:4]):
    title_m = re.search(r'class="prod_title">([^<]+)</h4>', card)
    title = title_m.group(1) if title_m else "No title"
    print(f"\n--- CARD {i+1}: {title} ---")
    rollover_m = re.search(r'<div class="rollover_inner".*?</div>\s*</div>\s*</div>', card, re.DOTALL)
    if rollover_m:
        print(rollover_m.group(0))
