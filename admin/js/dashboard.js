// const html = document.documentElement;
// const body = document.body;
// const menuLinks = document.querySelectorAll(".admin-menu a");
// const collapseBtn = document.querySelector(".admin-menu .collapse-btn");
// const toggleMobileMenu = document.querySelector(".toggle-mob-menu");
// const switchInput = document.querySelector(".switch input");
// const switchLabel = document.querySelector(".switch label");
// const switchLabelText = switchLabel.querySelector("span:last-child");
// const collapsedClass = "collapsed";
// const lightModeClass = "light-mode";

// /*TOGGLE HEADER STATE*/
// collapseBtn.addEventListener("click", function () {
//   body.classList.toggle(collapsedClass);
//   this.getAttribute("aria-expanded") == "true"
//     ? this.setAttribute("aria-expanded", "false")
//     : this.setAttribute("aria-expanded", "true");
//   this.getAttribute("aria-label") == "collapse menu"
//     ? this.setAttribute("aria-label", "expand menu")
//     : this.setAttribute("aria-label", "collapse menu");
// });

// /*TOGGLE MOBILE MENU*/
// toggleMobileMenu.addEventListener("click", function () {
//   body.classList.toggle("mob-menu-opened");
//   this.getAttribute("aria-expanded") == "true"
//     ? this.setAttribute("aria-expanded", "false")
//     : this.setAttribute("aria-expanded", "true");
//   this.getAttribute("aria-label") == "open menu"
//     ? this.setAttribute("aria-label", "close menu")
//     : this.setAttribute("aria-label", "open menu");
// });

// /*SHOW TOOLTIP ON MENU LINK HOVER*/
// for (const link of menuLinks) {
//   link.addEventListener("mouseenter", function () {
//     if (
//       body.classList.contains(collapsedClass) &&
//       window.matchMedia("(min-width: 768px)").matches
//     ) {
//       const tooltip = this.querySelector("span").textContent;
//       this.setAttribute("title", tooltip);
//     } else {
//       this.removeAttribute("title");
//     }
//   });
// }


// if (localStorage.getItem("dark-mode") === "false") {
//   html.classList.add(lightModeClass);
//   switchInput.checked = false;
//   switchLabelText.textContent = "Light";
// }

// switchInput.addEventListener("input", function () {
//   html.classList.toggle(lightModeClass);
//   if (html.classList.contains(lightModeClass)) {
//     switchLabelText.textContent = "Light";
//     localStorage.setItem("dark-mode", "false");
//   } else {
//     switchLabelText.textContent = "Dark";
//     localStorage.setItem("dark-mode", "true");
//   }
// });

// Search appointment
document.addEventListener('DOMContentLoaded', function() {
    
    // Real-time search functionality for today's appointments
    const searchBar = document.getElementById('search-bar');
    if (searchBar) {
        searchBar.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const tableBody = document.getElementById('appointment-table-body');
            const rows = tableBody.getElementsByTagName('tr');
            
            for (let row of rows) {
                const clientName = row.querySelector('.data-cla-name');
                if (clientName) {
                    const name = clientName.textContent.toLowerCase();
                    if (name.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            }
        });
    }
    
    // Real-time search functionality for upcoming appointments
    const searchBarTwo = document.getElementById('search-bar-two');
    if (searchBarTwo) {
        searchBarTwo.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const tableBody = document.getElementById('appointment-two-table-body');
            const rows = tableBody.getElementsByTagName('tr');
            
            for (let row of rows) {
                const clientName = row.querySelector('.data-two-cla-name');
                if (clientName) {
                    const name = clientName.textContent.toLowerCase();
                    if (name.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            }
        });
    }
    
    // Auto-refresh dashboard data every 5 minutes
    setInterval(function() {
        // You can add AJAX call here to refresh data without page reload
        // For now, we'll just show a subtle notification
        console.log('Dashboard data refresh check...');
    }, 300000); // 5 minutes
    
    // Add loading states for better UX
    function showLoading(element) {
        if (element) {
            element.style.opacity = '0.5';
            element.style.pointerEvents = 'none';
        }
    }
    
    function hideLoading(element) {
        if (element) {
            element.style.opacity = '1';
            element.style.pointerEvents = 'auto';
        }
    }
    
    // Handle form submissions with loading states
    const searchForms = document.querySelectorAll('form');
    searchForms.forEach(form => {
        form.addEventListener('submit', function() {
            const searchInput = form.querySelector('input[type="text"]');
            if (searchInput && searchInput.value.trim() !== '') {
                showLoading(document.querySelector('.content-section'));
            }
      });
  });

    // Add hover effects for better interactivity
    const dashboardItems = document.querySelectorAll('.dashboard-items');
    dashboardItems.forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
            this.style.boxShadow = '0 4px 8px rgba(0,0,0,0.1)';
        });
        
        item.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = 'none';
        });
    });
    
    // Add click tracking for analytics (optional)
    const appointmentLinks = document.querySelectorAll('a[href*="appointment"]');
    appointmentLinks.forEach(link => {
        link.addEventListener('click', function() {
            console.log('Appointment section accessed from dashboard');
        });
    });
    
    // Handle empty state styling
    function styleEmptyStates() {
        const emptyRows = document.querySelectorAll('td[colspan="4"]');
        emptyRows.forEach(row => {
            if (row.textContent.includes('No appointments')) {
                row.style.fontStyle = 'italic';
                row.style.color = '#999';
            }
        });
    }
    
    // Initialize empty state styling
    styleEmptyStates();
    
    // Add keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + F to focus on first search box
        if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
            e.preventDefault();
            const firstSearch = document.getElementById('search-bar');
            if (firstSearch) {
                firstSearch.focus();
            }
        }
        
        // Escape to clear search
        if (e.key === 'Escape') {
            const activeSearch = document.activeElement;
            if (activeSearch && activeSearch.classList.contains('input-search-name')) {
                activeSearch.value = '';
                activeSearch.dispatchEvent(new Event('input'));
            }
        }
    });
    
    // Add responsive table scrolling
    const scrollContainers = document.querySelectorAll('.scroll');
    scrollContainers.forEach(container => {
        if (container.scrollWidth > container.clientWidth) {
            container.style.overflowX = 'auto';
        }
    });
    
    // Add tooltips for better UX
    const tooltipElements = document.querySelectorAll('.dashboard-items, .btn-primary');
    tooltipElements.forEach(element => {
        element.title = element.textContent.trim();
    });
    
    console.log('Dashboard JavaScript loaded successfully');
  });