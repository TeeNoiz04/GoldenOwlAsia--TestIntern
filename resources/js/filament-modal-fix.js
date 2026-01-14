document.addEventListener('DOMContentLoaded', () => {
    const observer = new MutationObserver(() => {
        document
            .querySelectorAll('.fi-modal-close-overlay')
            .forEach(overlay => {
                const hasModal = overlay.parentElement?.querySelector('.fi-modal')
                if (!hasModal) {
                    overlay.remove()
                }
            })
    })

    observer.observe(document.body, {
        childList: true,
        subtree: true,
    })
})
