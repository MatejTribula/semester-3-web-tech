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

    const removeBtn = document.createElement('button');
    removeBtn.type = 'button';
    removeBtn.className = 'remove-field';
    removeBtn.textContent = '−';
    removeBtn.title = 'Remove';
    removeBtn.addEventListener('click', function () {
        row.remove();
        updateRemoveButtons(wrapperId);
        ensureAtLeastOne(wrapperId, name, type, placeholder);
    });
    row.appendChild(removeBtn);

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

document.addEventListener('DOMContentLoaded', function() 
{
    // ensure initial fields exist
    if (document.getElementById('tags-wrapper') && !document.getElementById('tags-wrapper').querySelector('.field-row')) 
    {
        addField('tags-wrapper', 'tags[]', 'text', 'Tag');
    }
    if (document.getElementById('collaborators-wrapper') && !document.getElementById('collaborators-wrapper').querySelector('.field-row')) 
    {
        addField('collaborators-wrapper', 'collaborators[]', 'number', 'User ID');
        const firstInput = document.querySelector('#collaborators-wrapper .field-row input');
        if (firstInput) firstInput.value = "{{ auth()->id() }}";
        if (firstInput) firstInput.readOnly = true;
    }
});