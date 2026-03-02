# LinguaVoice Development Workflow

## Project goal
Create a single-file responsive landing page for "LinguaVoice" agency.

## Workflow Steps

1.  **Setup**
    - [x] Create `assets` folder.
    - [x] Create this `workflow.md` file.

2.  **Implementation**
    - [ ] Create `index.html`.
    - [ ] Implement structure with Bootstrap 5.
    - [ ] Add Custom CSS for "Dark Navy & Teal" theme.
    - [ ] Add Sections: Hero, Services, Why Us, Portfolio, CTA, Footer.
    - [ ] Add Interactivity: AOS Animations, SweetAlert2 for buttons.

3.  **Review**
    - [ ] Check responsiveness (Mobile/Desktop).
    - [ ] Verify functionality (No backend, smooth scroll).

## Constraints
- Single HTML file.
- Use CDNs.
- No backend logic.
# Implementation Plan - LinguaVoice Landing Page

## Goal
Create a complete, responsive, single-file HTML landing page for "LinguaVoice" agency, focusing on a premium design, specific sections, and interactivity without a backend.

## Proposed Changes

### [Root]
#### [NEW] [index.html](file:///d:/Project/company-template/index.html)
- **Structure**: HTML5
- **Libraries (CDNs)**:
    - Bootstrap 5.3 CSS & JS
    - AOS (Animate On Scroll) CSS & JS
    - FontAwesome 6
    - SweetAlert2
    - Google Fonts (Montserrat, Open Sans)
- **Design System**:
    - Colors: Dark Navy Blue (`#0a192f`), Clean White (`#ffffff`), Vibrant Teal/Green (`#64ffda`)
    - Fonts: Montserrat (Headings), Open Sans (Body)
    - Animations: AOS fade-up, zoom-in
- **Sections**:
    1.  **Navbar**: Fixed, transparent transition to solid on scroll.
    2.  **Hero**: Full viewport height (`100vh`), background image, CTA.
    3.  **Services**: 3-column grid with FontAwesome icons.
    4.  **Why Us**: 3-column grid with icons.
    5.  **Portfolio**: Placeholder logos.
    6.  **CTA**: High contrast area.
    7.  **Footer**: Simple links/copyright.
    8.  **Floating Button**: WhatsApp with pulsing animation.
- **Interactivity**:
    - JavaScript for Navbar scroll effect.
    - AOS initialization.
    - SweetAlert2 for buttons (simulating WhatsApp redirect).

## Verification Plan
### Manual Verification
- Since this is a single file, I will inspect the code to ensure:
    - All CDNs are present.
    - CSS overrides Bootstrap defaults effectively.
    - JavaScript handles the "Contact" click as requested.
    - Responsive classes (`col-md-4`, `d-flex`, etc.) are used correctly.
