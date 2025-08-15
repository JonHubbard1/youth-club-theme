# Youth Club Theme

A WordPress theme specifically created for youth clubs, charity organisations, and healthcare providers supporting young people and families.

## Features

### Design
- Clean, compassionate design aesthetic
- Red (#e74c3c) primary colour scheme inspired by healthcare/charity sector
- Mobile-first responsive design
- Accessibility-focused with proper ARIA labels and keyboard navigation
- Professional typography using system fonts

### Layout Components
- **Hero Section**: Customisable with title, subtitle, and call-to-action buttons
- **Impact Statistics**: Animated counters showing organisational impact
- **Services Cards**: Grid layout showcasing programmes and services
- **Testimonials**: Stories from families and programme participants
- **Latest News**: Integration with WordPress blog functionality
- **Call-to-Action Sections**: Donation and volunteer recruitment areas

### WordPress Integration
- Full WordPress Customiser support
- Custom post types ready
- Widget areas for footer content
- Multiple navigation menu locations
- Featured image support
- Comments system integration
- Search functionality

### Templates Included
- `index.php` - Main template
- `front-page.php` - Custom homepage
- `page.php` - Individual pages
- `single.php` - Blog posts with related posts
- `header.php` - Site header with navigation
- `footer.php` - Site footer with contact info
- `comments.php` - Comment system
- `404.php` - Custom error page
- `searchform.php` - Search form template

### Customisation Options

All theme customization is done through the **WordPress Customizer** (Appearance → Customize). The theme provides comprehensive controls for visual customization without requiring CSS knowledge.

#### Logo & Branding
- **Custom Logo Upload**: Upload your organization's logo
- **Logo Height**: Adjust logo size (default: 80px)
- **Logo Bottom Margin**: Control spacing below logo (default: 20px)

#### Color Scheme
Complete color control with live preview:
- **Primary Color**: Main brand color (default: #e74c3c)
- **Secondary Color**: Supporting color (default: #2c3e50)
- **Accent Color**: Highlight color (default: #3498db)
- **Heading Color**: Text color for headings (default: #2c3e50)
- **Body Text Color**: Main text color (default: #333333)
- **Link Color**: Color for links (default: #e74c3c)
- **Header Background**: Header section background (default: #ffffff)
- **Footer Background**: Footer section background (default: #2c3e50)

#### Typography
Professional font controls with Google Fonts integration:
- **Heading Font**: Choose from 13 professional fonts including:
  - Inter (default)
  - Arial, Helvetica
  - Georgia, Times New Roman
  - Google Fonts: Roboto, Open Sans, Lato, Montserrat, Playfair Display, Merriweather
- **Body Font**: Separate font control for body text
- **Heading Font Size**: Adjustable from 18px to 48px (default: 28px)
- **Body Font Size**: Adjustable from 12px to 24px (default: 16px)
- **Line Height**: Text spacing from 1.2 to 2.0 (default: 1.6)

#### Hero Section
- Hero title and subtitle
- Primary and secondary button text/links
- Donation button configuration

#### Impact Statistics
- Four customisable statistics with numbers and labels
- Animated counters that trigger on scroll

#### Contact Information
- Phone number
- Email address
- Physical address
- Social media links (Facebook, Twitter, Instagram, LinkedIn)

#### Footer Settings
- About text
- Copyright information
- Multiple menu locations

#### Live Preview
All customization changes appear instantly in the Customizer preview, allowing you to see exactly how your site will look before publishing changes.

### Technical Features
- **Performance**: Optimised CSS and JavaScript
- **SEO**: Proper heading structure and meta tags
- **Security**: WordPress security best practices
- **Accessibility**: WCAG 2.1 AA compliant
- **Browser Support**: Modern browsers with progressive enhancement

### Installation

1. Upload the theme folder to `/wp-content/themes/`
2. Activate the theme in WordPress Admin
3. Go to **Appearance → Customize** to configure your theme:
   - **Logo & Branding**: Upload your logo and adjust sizing
   - **Color Scheme**: Set your brand colors with live preview
   - **Typography**: Choose fonts and adjust text sizing
   - **Hero Section**: Configure your homepage banner
   - **Statistics**: Set up your impact numbers
   - **Contact Information**: Add your contact details and social links
   - **Footer Settings**: Configure footer content
4. Set up your navigation menus in **Appearance → Menus**
5. Create your homepage content
6. All changes are instantly visible with live preview in the Customizer

### Recommended Plugins
- **Contact Form**: Everest Forms or Contact Form 7
- **SEO**: Rank Math or Yoast SEO
- **Performance**: LiteSpeed Cache or WP Rocket
- **Security**: Wordfence or Sucuri

### Menu Locations
- **Primary**: Main navigation header menu
- **Footer Links**: Quick links in footer
- **Footer Services**: Services menu in footer
- **Footer Legal**: Legal/policy links in footer

### Widget Areas
- **Sidebar**: Main sidebar for pages/posts
- **Footer Widget Area 1**: First footer column
- **Footer Widget Area 2**: Second footer column

### Colour Palette
- **Primary Red**: #e74c3c
- **Dark Blue**: #2c3e50
- **Light Blue**: #3498db
- **Orange**: #f39c12
- **Light Gray**: #f8f9fa

### Typography
- **Headings**: Inter, system fonts
- **Body**: System font stack for optimal performance
- **Sizes**: Responsive typography scale

### Browser Support
- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Internet Explorer 11+ (graceful degradation)

### Development

#### File Structure
```
easyYouthClub/
├── style.css              # Main stylesheet with theme header
├── index.php             # Main template
├── front-page.php        # Homepage template
├── functions.php         # Theme functionality & Customizer controls
├── header.php            # Header template
├── footer.php            # Footer template
├── page.php              # Page template
├── single.php            # Single post template
├── comments.php          # Comments template
├── 404.php               # 404 error template
├── searchform.php        # Search form template
├── js/
│   ├── navigation.js     # Theme JavaScript
│   └── customizer-preview.js  # Live preview functionality
└── README.md             # This file
```

#### Customisation
The theme follows WordPress coding standards and uses hooks and filters for customisation. Key functions are prefixed with `youth_club_theme_`.

#### Child Theme Support
This theme supports child themes for safe customisation. Create a child theme for any modifications to preserve them during theme updates.

### Support
For support with this theme, please refer to WordPress theme development documentation or contact the theme developer.

### Credits
- Created by Technoliga
- Built for the Easy Youth Club plugin ecosystem
- Follows WordPress theme development best practices

### License
This theme is released under the GPL v2 or later license.

### Changelog

#### Version 1.1.0
- **Enhanced WordPress Customizer Integration**
- Added comprehensive Logo & Branding controls with logo upload and sizing
- Added complete Color Scheme customization with 8 color controls
- Added Typography controls with 13 font choices and Google Fonts integration
- Added live preview functionality for all customization changes
- Implemented CSS custom properties for efficient style updates
- Removed need for manual CSS editing - all customization through Customizer

#### Version 1.0.0
- Initial release
- Complete homepage design
- Full WordPress integration
- Basic Customizer support
- Responsive design
- Accessibility features