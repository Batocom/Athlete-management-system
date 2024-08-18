// admin.js

// Function to show the selected section
function showSection(sectionId) {
    // Hide all sections
    const sections = document.querySelectorAll('.main-content > div');
    sections.forEach(section => {
        section.style.display = section.id === sectionId ? 'block' : 'none';
    });
}

// Add event listeners to sidebar links
document.addEventListener('DOMContentLoaded', () => {
    // Get all sidebar links
    const sidebarLinks = document.querySelectorAll('.sidebar .nav li a');

    // Add click event listener to each link
    sidebarLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const sectionId = link.getAttribute('data-section');
            showSection(sectionId);
        });
    });
});
