import re

with open('d:/Group-A-CMS-FINAL/scratch_coffee.html', encoding='utf-8') as f:
    html = f.read()

# Let's search for prod_title and its following rollover_content
items = re.findall(r'<h4 class="prod_title">([^<]+)</h4>\s*</div>\s*<div class="rollover_content">(.*?)<p class="rollover_short">', html, re.DOTALL)

print(f"Found {len(items)} rollover products:")
for title, content in items:
    # clean tags slightly for display
    print(f"=== {title.strip()} ===")
    print(content.strip())
    print("\n")
