function alertShow() {
    const popup = document.getElementById('popupNotification');
    popup.style.display = 'block'; 
    setTimeout(() => {
        popup.style.display = 'none'; 
    }, 3000);
}