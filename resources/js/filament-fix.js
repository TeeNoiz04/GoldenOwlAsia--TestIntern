document.addEventListener('DOMContentLoaded', () => {
    // Ép Filament luôn ở light mode
    document.documentElement.classList.remove('dark')

    // Chặn Alpine / Filament add lại dark
    const observer = new MutationObserver(() => {
        document.documentElement.classList.remove('dark')
    })

    observer.observe(document.documentElement, {
        attributes: true,
        attributeFilter: ['class'],
    })
})
