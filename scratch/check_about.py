import re

with open('d:/Group-A-CMS-FINAL/scratch_about.html', encoding='utf-8') as f:
    html = f.read()

# Let's see what is inside <header> and after <header> up to <div class="quills-hero-banner">
header_pos = html.find('<header')
hero_pos = html.find('quills-hero-banner')

print("Between header and hero:")
print(html[header_pos:hero_pos])
