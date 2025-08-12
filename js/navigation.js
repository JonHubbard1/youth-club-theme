/**
 * Theme navigation JavaScript
 */

(function() {
    'use strict';

    // Mobile menu toggle functionality
    function initMobileMenu() {
        const toggleButton = document.querySelector('.mobile-menu-toggle');
        const navigation = document.querySelector('.main-navigation');
        const menuIcon = document.querySelector('.menu-icon');
        
        if (!toggleButton || !navigation) {
            return;
        }

        toggleButton.addEventListener('click', function() {
            const expanded = this.getAttribute('aria-expanded') === 'true';
            
            // Toggle aria-expanded
            this.setAttribute('aria-expanded', !expanded);
            
            // Toggle navigation active class
            navigation.classList.toggle('active');
            
            // Toggle menu icon
            if (menuIcon) {
                menuIcon.textContent = expanded ? '☰' : '✕';
            }
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            if (!navigation.contains(event.target) && !toggleButton.contains(event.target)) {
                navigation.classList.remove('active');
                toggleButton.setAttribute('aria-expanded', 'false');
                if (menuIcon) {
                    menuIcon.textContent = '☰';
                }
            }
        });

        // Close mobile menu when pressing escape
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && navigation.classList.contains('active')) {
                navigation.classList.remove('active');
                toggleButton.setAttribute('aria-expanded', 'false');
                if (menuIcon) {
                    menuIcon.textContent = '☰';
                }
                toggleButton.focus();
            }
        });

        // Close mobile menu when window is resized to desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                navigation.classList.remove('active');
                toggleButton.setAttribute('aria-expanded', 'false');
                if (menuIcon) {
                    menuIcon.textContent = '☰';
                }
            }
        });
    }

    // Smooth scrolling for anchor links
    function initSmoothScrolling() {
        const links = document.querySelectorAll('a[href^="#"]');
        
        links.forEach(link => {
            link.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                
                // Skip if it's just a hash
                if (href === '#') {
                    return;
                }
                
                const target = document.querySelector(href);
                
                if (target) {
                    e.preventDefault();
                    
                    // Calculate offset for fixed header
                    const headerOffset = 80;
                    const elementPosition = target.getBoundingClientRect().top;
                    const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
                    
                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });
                    
                    // Update URL hash
                    if (history.pushState) {
                        history.pushState(null, null, href);
                    }
                }
            });
        });
    }

    // Header scroll effect
    function initHeaderScrollEffect() {
        const header = document.querySelector('.site-header');
        let lastScrollTop = 0;
        let ticking = false;

        if (!header) {
            return;
        }

        function updateHeader() {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            if (scrollTop > 100) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
            
            // Hide/show header on scroll
            if (scrollTop > lastScrollTop && scrollTop > 200) {
                header.style.transform = 'translateY(-100%)';
            } else {
                header.style.transform = 'translateY(0)';
            }
            
            lastScrollTop = scrollTop;
            ticking = false;
        }

        function requestTick() {
            if (!ticking) {
                requestAnimationFrame(updateHeader);
                ticking = true;
            }
        }

        window.addEventListener('scroll', requestTick);
    }

    // Accessibility improvements
    function initAccessibility() {
        // Add skip link functionality
        const skipLink = document.querySelector('.skip-link');
        if (skipLink) {
            skipLink.addEventListener('click', function(e) {
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.setAttribute('tabindex', '-1');
                    target.focus();
                    target.addEventListener('blur', function() {
                        this.removeAttribute('tabindex');
                    }, { once: true });
                }
            });
        }

        // Improve keyboard navigation for dropdown menus
        const menuItems = document.querySelectorAll('.main-navigation a');
        const parentItems = document.querySelectorAll('.main-navigation .menu-item-has-children');
        
        menuItems.forEach(item => {
            item.addEventListener('focus', function() {
                // Remove focus from other menu items
                menuItems.forEach(otherItem => {
                    if (otherItem !== this) {
                        otherItem.parentElement.classList.remove('focus');
                    }
                });
                
                // Add focus to current item
                this.parentElement.classList.add('focus');
                
                // Show dropdown when parent item is focused
                const parentItem = this.closest('.menu-item-has-children');
                if (parentItem) {
                    parentItem.classList.add('focus-within');
                }
            });

            item.addEventListener('blur', function() {
                // Delay removal to allow focus to move to submenu items
                setTimeout(() => {
                    const parentItem = this.closest('.menu-item-has-children');
                    if (parentItem && !parentItem.querySelector(':focus')) {
                        parentItem.classList.remove('focus-within');
                    }
                    this.parentElement.classList.remove('focus');
                }, 100);
            });
            
            // Handle keyboard navigation
            item.addEventListener('keydown', function(e) {
                const parentLi = this.parentElement;
                const submenu = parentLi.querySelector('ul');
                
                switch(e.key) {
                    case 'ArrowDown':
                        e.preventDefault();
                        if (submenu) {
                            // Focus first item in submenu
                            const firstSubmenuItem = submenu.querySelector('a');
                            if (firstSubmenuItem) {
                                firstSubmenuItem.focus();
                            }
                        } else {
                            // Move to next menu item
                            const nextLi = parentLi.nextElementSibling;
                            if (nextLi) {
                                const nextLink = nextLi.querySelector('a');
                                if (nextLink) nextLink.focus();
                            }
                        }
                        break;
                        
                    case 'ArrowUp':
                        e.preventDefault();
                        // Move to previous menu item or parent
                        const prevLi = parentLi.previousElementSibling;
                        if (prevLi) {
                            const prevLink = prevLi.querySelector('a');
                            if (prevLink) prevLink.focus();
                        } else {
                            // If in submenu, go to parent
                            const parentMenu = parentLi.closest('ul').parentElement;
                            if (parentMenu && parentMenu.classList.contains('menu-item-has-children')) {
                                const parentLink = parentMenu.querySelector('a');
                                if (parentLink) parentLink.focus();
                            }
                        }
                        break;
                        
                    case 'ArrowRight':
                        e.preventDefault();
                        if (submenu) {
                            // Open submenu and focus first item
                            const firstSubmenuItem = submenu.querySelector('a');
                            if (firstSubmenuItem) {
                                firstSubmenuItem.focus();
                            }
                        }
                        break;
                        
                    case 'ArrowLeft':
                        e.preventDefault();
                        // Close submenu and return to parent
                        const parentSubmenu = parentLi.closest('ul');
                        if (parentSubmenu && parentSubmenu.parentElement.classList.contains('menu-item-has-children')) {
                            const parentLink = parentSubmenu.parentElement.querySelector('a');
                            if (parentLink) parentLink.focus();
                        }
                        break;
                        
                    case 'Escape':
                        e.preventDefault();
                        // Close all submenus and return to main menu
                        const mainMenuItem = parentLi.closest('.main-navigation > ul > li');
                        if (mainMenuItem) {
                            const mainLink = mainMenuItem.querySelector('a');
                            if (mainLink) mainLink.focus();
                        }
                        break;
                }
            });
        });
        
        // Handle touch/click for mobile dropdown menus
        parentItems.forEach(parentItem => {
            const parentLink = parentItem.querySelector('a');
            const submenu = parentItem.querySelector('ul');
            
            if (parentLink && submenu) {
                parentLink.addEventListener('click', function(e) {
                    // On mobile, prevent default and toggle submenu
                    if (window.innerWidth <= 768) {
                        e.preventDefault();
                        parentItem.classList.toggle('mobile-open');
                    }
                });
                
                // Add touch start for better mobile experience
                parentLink.addEventListener('touchstart', function(e) {
                    if (window.innerWidth <= 768) {
                        e.preventDefault();
                        parentItem.classList.toggle('mobile-open');
                    }
                });
            }
        });
        
        // Close dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.main-navigation')) {
                parentItems.forEach(item => {
                    item.classList.remove('focus-within', 'mobile-open');
                });
            }
        });
    }

    // Stats counter animation
    function initStatsAnimation() {
        const statNumbers = document.querySelectorAll('.stat-number');
        
        if (!statNumbers.length) {
            return;
        }

        const animateNumber = (element) => {
            const target = element.textContent.replace(/[^\d]/g, '');
            const increment = Math.ceil(target / 50);
            let current = 0;
            
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }
                
                // Preserve formatting (commas, percentage signs, etc.)
                const originalText = element.textContent;
                const hasComma = originalText.includes(',');
                const hasPercent = originalText.includes('%');
                
                let displayValue = current.toString();
                if (hasComma && current >= 1000) {
                    displayValue = current.toLocaleString();
                }
                if (hasPercent) {
                    displayValue += '%';
                }
                
                element.textContent = displayValue;
            }, 30);
        };

        // Use Intersection Observer to trigger animation when stats come into view
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateNumber(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        });

        statNumbers.forEach(stat => {
            observer.observe(stat);
        });
    }

    // Card hover effects
    function initCardEffects() {
        const cards = document.querySelectorAll('.card');
        
        cards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    }

    // Initialize all functionality when DOM is ready
    function init() {
        initMobileMenu();
        initSmoothScrolling();
        initHeaderScrollEffect();
        initAccessibility();
        initStatsAnimation();
        initCardEffects();
    }

    // DOM ready check
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

})();