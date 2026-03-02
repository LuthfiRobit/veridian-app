
import os
import re

# Update portfolio-details.css
css_path = r'd:\Project\company-template\assets\css\portfolio-details.css'
with open(css_path, 'r', encoding='utf-8') as f:
    css_content = f.read()

# Styles to insert
breadcrumb_styles = """
/* Breadcrumbs - Matches Team/About Page */
.portfolio-details-page .breadcrumbs {
    background: rgba(27, 94, 32, 0.95);
    padding: 14px 0;
    margin-bottom: 0;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    box-shadow: none;
    backdrop-filter: none;
    border-radius: 0;
    position: relative;
    z-index: 2;
}

.portfolio-details-page .breadcrumbs .container {
    position: relative;
    z-index: 2;
}

.portfolio-details-page .breadcrumbs ol {
    list-style: none;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 8px;
    margin: 0;
    padding: 0;
    font-size: 14px;
}

.portfolio-details-page .breadcrumbs ol li {
    display: flex;
    align-items: center;
    color: rgba(255, 255, 255, 0.7);
}

.portfolio-details-page .breadcrumbs ol li+li::before {
    content: "/";
    margin-right: 8px;
    color: rgba(255, 255, 255, 0.4);
}

.portfolio-details-page .breadcrumbs ol li a {
    color: rgba(255, 255, 255, 0.9);
    text-decoration: none;
    transition: all 0.3s ease;
}

.portfolio-details-page .breadcrumbs ol li a:hover {
    color: #ffffff;
    text-decoration: none;
}

.portfolio-details-page .breadcrumbs ol li.current {
    color: rgba(255, 255, 255, 0.95);
    font-weight: 600;
}
"""

if "/* Portfolio Details Section */" in css_content:
    css_content = css_content.replace("/* Portfolio Details Section */", breadcrumb_styles + "\n\n/* Portfolio Details Section */")
    with open(css_path, 'w', encoding='utf-8') as f:
        f.write(css_content)
    print("Updated portfolio-details.css")
else:
    print("Could not find insertion point in portfolio-details.css")

# Update Portfolio HTML files
portfolio_dir = r'd:\Project\company-template\portfolio'
for filename in os.listdir(portfolio_dir):
    if filename.endswith(".html"):
        filepath = os.path.join(portfolio_dir, filename)
        with open(filepath, 'r', encoding='utf-8') as f:
            content = f.read()
        
        # Regex to capture content
        # Matches the old structure
        pattern = re.compile(r'<div class="page-title page-title-animated.*?<div class="breadcrumbs">.*?<ol class="breadcrumb">(.*?)</ol>.*?</div>.*?<div class="title-wrapper">\s*<h1>(.*?)</h1>\s*<p>(.*?)</p>\s*</div>\s*</div>', re.DOTALL)
        
        match = pattern.search(content)
        if match:
            breadcrumbs_inner = match.group(1)
            title = match.group(2)
            desc = match.group(3)
            
            # Clean up breadcrumbs
            # Remove class="breadcrumb-item..." and i tags if needed, or adapt
            # We need to transform <li class="breadcrumb-item..."><a...>...</a></li> to <li><a...>...</a></li>
            
            new_breadcrumbs = []
            li_pattern = re.compile(r'<li.*?>(.*?)</li>', re.DOTALL)
            for li_match in li_pattern.finditer(breadcrumbs_inner):
                inner_li = li_match.group(1).strip()
                # Remove class="active current" or similar if we want standard li
                # Removing inner tags like <i class="bi bi-house"></i>? Maybe keep icon
                # Ensure the last one is marked current
                
                # Simple cleanup: preserve inner content (A tag or text)
                # But logical structure:
                # Top level: <li><a href...>Home</a></li>
                # ...
                # Last: <li class="current">Title</li>
                
                # Check if it was active/current in old HTML
                if 'active' in li_match.group(0) or 'current' in li_match.group(0):
                    new_breadcrumbs.append(f'<li class="current">{inner_li}</li>')
                else:
                    new_breadcrumbs.append(f'<li>{inner_li}</li>')
            
            breadcrumbs_html = '\n                        '.join(new_breadcrumbs)
            
            new_structure = f"""<div class="page-title page-title-animated">
    <div class="heading">
        <div class="container">
            <div class="row d-flex justify-content-center text-center">
                <div class="col-lg-8">
                    <h1>{title}</h1>
                    <p class="mb-0">{desc}</p>
                </div>
            </div>
        </div>
    </div>
    <nav class="breadcrumbs">
        <div class="container">
            <ol>
                {breadcrumbs_html}
            </ol>
        </div>
    </nav>
</div>"""
            
            new_content = pattern.sub(new_structure, content)
            
            with open(filepath, 'w', encoding='utf-8') as f:
                f.write(new_content)
            print(f"Updated {filename}")
        else:
            print(f"Pattern not found in {filename}")
