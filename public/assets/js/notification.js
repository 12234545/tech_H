
document.addEventListener('DOMContentLoaded', () => {
    const notificationTrigger = document.querySelector('.modern-notification-trigger');
    const notificationPanel = document.querySelector('.modern-notification-panel');
    const clearNotificationsBtn = document.querySelector('.modern-notification-clear');

    // Toggle notification panel
    notificationTrigger.addEventListener('click', (e) => {
        e.stopPropagation();
        notificationPanel.classList.toggle('is-visible');
    });

    // Close panel when clicking outside
    document.addEventListener('click', (e) => {
        if (!notificationPanel.contains(e.target) &&
            !notificationTrigger.contains(e.target)) {
            notificationPanel.classList.remove('is-visible');
        }
    });

    // Clear all notifications
    if (clearNotificationsBtn) {
        clearNotificationsBtn.addEventListener('click', () => {
            const notificationList = document.querySelector('.modern-notification-list');
            notificationList.innerHTML = `
                <div class="modern-notification-empty">
                    <p>No new notifications</p>
                </div>
            `;
        });
    }

    // Optional: Smooth scroll for notification list
    const notificationList = document.querySelector('.modern-notification-list');
    if (notificationList) {
        notificationList.addEventListener('wheel', (e) => {
            e.preventDefault();
            notificationList.scrollLeft += e.deltaY;
        });
    }
});
