function addField(wrapperId, name, type, placeholder) 
{
    const wrapper = document.getElementById(wrapperId);
    const row = document.createElement('div');
    row.className = 'field-row';

    const input = document.createElement('input');
    input.type = type;
    input.name = name;
    input.placeholder = placeholder;
    if (name === 'tags[]') input.maxLength = 32;
    row.appendChild(input);


    const removeIcon = document.createElement('i');
    removeIcon.className = 'fa-solid fa-times remove-field';
    removeIcon.id = 'remove-field-icon';
    removeIcon.style.cursor = 'pointer';
    removeIcon.title = 'Remove';
    removeIcon.addEventListener('click', function () {
        row.remove();
        updateRemoveButtons(wrapperId);
        ensureAtLeastOne(wrapperId, name, type, placeholder);
    });
    row.appendChild(removeIcon);

    wrapper.appendChild(row);
    updateRemoveButtons(wrapperId);
}

function updateRemoveButtons(wrapperId) 
{
    const wrapper = document.getElementById(wrapperId);
    if (!wrapper) return;
    const rows = wrapper.querySelectorAll('.field-row');
    rows.forEach((row, idx) => {
        const btn = row.querySelector('.remove-field');
        if (!btn) return;
        // hide remove for the first row, show for others
        btn.style.display = idx === 0 ? 'none' : '';
    });
}

function ensureAtLeastOne(wrapperId, name, type, placeholder)
{
    const wrapper = document.getElementById(wrapperId);
    if (!wrapper) return;
    if (!wrapper.querySelector('.field-row')) 
    {
        addField(wrapperId, name, type, placeholder);
    }
}

