with open('d:/Group-A-CMS-FINAL/scratch_prod.html', encoding='utf-8') as f:
    html = f.read()

rev_pos = html.find('quills-reviews-section')
if rev_pos != -1:
    print("Found reviews section!")
    print(html[rev_pos:rev_pos+1500].encode('ascii', errors='replace').decode('ascii'))
else:
    print("Review section NOT found!")
