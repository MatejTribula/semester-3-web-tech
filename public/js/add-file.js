(function () {
    if (window.__addFileInit) return;
    window.__addFileInit = true;

    function createAddCardElement(attrs = {}) 
    {
        const el = document.createElement('div');
        el.className = 'card add-game-card add-file-card';
        el.setAttribute('role', 'button');
        el.setAttribute('tabindex', '0');

        if (attrs.type) el.setAttribute('data-type', attrs.type);
        if (attrs.name) el.setAttribute('data-name', attrs.name);
        if (attrs.id) el.setAttribute('data-id', attrs.id);
        if (attrs.wrapper) el.setAttribute('data-wrapper', attrs.wrapper);
        if (attrs.logo) el.setAttribute('data-logo', attrs.logo);

        el.innerHTML = '<div class="card-img"><i class="fa-solid fa-plus plus-icon"></i></div>';
        return el;
    }

    document.addEventListener('click', function (e) 
    {
        const card = e.target.closest('.add-file-card');
        if (!card) return;

        const clickedPlusIcon = e.target.classList && e.target.classList.contains('plus-icon');
        const hasImg = !!card.querySelector('img');
        if (hasImg && !clickedPlusIcon) return;

        const url = window.prompt('Enter the file URL:');
        if (!url) return;

        // Do not create a new add-card if this instance is a logo OR the game file slot (file_url)
        const isLogo = card.getAttribute('data-logo') === '1';
        const isGameFile = (card.getAttribute('data-name') === 'file_url') || (card.getAttribute('data-id') === 'file_url');

        card.innerHTML = '';
        card.style.position = card.style.position || 'relative';

        const imgWrap = document.createElement('div');
        imgWrap.className = 'card-img';
        const img = document.createElement('img');
        img.src = url;
        img.alt = 'preview';
        img.style.width = '100%';
        img.style.height = '175px';
        img.style.objectFit = 'cover';

        if(!isLogo && !isGameFile)
        {
            const removeBtn = document.createElement('button');
            removeBtn.className = 'remove-btn';
            removeBtn.innerHTML = '&times;';
            removeBtn.onclick = function (e) 
            {
                e.stopPropagation();
                if (confirm('Are you sure you want to remove this file?')) 
                {
                    // Remove associated hidden input if exists
                    const wrapperId = card.getAttribute('data-wrapper');
                    const givenName = card.getAttribute('data-name');
                    const givenId = card.getAttribute('data-id');

                    if (wrapperId) 
                    {
                        const wrap = document.getElementById(wrapperId);
                        if (wrap) 
                        {
                            const inputs = wrap.querySelectorAll('input');
                            inputs.forEach(input => {
                                if (input.value === img.src) {
                                    wrap.removeChild(input);
                                }
                            });
                        }
                    } 
                    else if (givenName) 
                    {
                        const nextInput = card.nextSibling;
                        if (nextInput && nextInput.tagName === 'INPUT' && nextInput.name === givenName && nextInput.value === img.src) 
                        {
                            nextInput.remove();
                        }
                    }

                    card.remove();
                }
            };
            card.appendChild(removeBtn);
        }
        img.onclick = function (e) 
        {
            e.stopPropagation();
            const newUrl = window.prompt('Enter the new file URL:', img.src);
            if (newUrl) img.src = newUrl;
        };
        imgWrap.appendChild(img);
        card.appendChild(imgWrap);

        const wrapperId = card.getAttribute('data-wrapper');
        const givenName = card.getAttribute('data-name');
        const givenId = card.getAttribute('data-id');
        const inputName = givenName || 'files[]';
        const inputType = card.getAttribute('data-type') || 'url';

        if (wrapperId) 
        {
            const wrap = document.getElementById(wrapperId);
            if (wrap) 
            {
                const input = document.createElement('input');
                input.type = 'hidden';           // invisible but submitted
                input.name = inputName;
                input.value = url;
                input.setAttribute('data-preview-url', url);
                wrap.appendChild(input);
            }
        }  else if (givenName) 
        {
            const input = document.createElement('input');
            input.type = inputType;
            input.name = givenName;
            if (givenId) input.id = givenId;
            input.value = url;
            input.style.display = 'none';
            card.parentNode.insertBefore(input, card.nextSibling);
        }



        if (!isLogo && !isGameFile) 
        {
            const attrs = {
                type: card.getAttribute('data-type') || undefined,
                name: card.getAttribute('data-name') || undefined,
                id: card.getAttribute('data-id') || undefined,
                wrapper: card.getAttribute('data-wrapper') || undefined,
                logo: card.getAttribute('data-logo') || undefined,
            };
            const newCard = createAddCardElement(attrs);
            card.parentNode.insertBefore(newCard, card.nextSibling);
            newCard.focus();
        }
    });
})();