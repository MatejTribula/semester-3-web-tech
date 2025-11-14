document.addEventListener('DOMContentLoaded', function () 
{
  const btn = document.getElementById('favorite-btn');
  if (!btn) return;

  const starIcon = btn.querySelector('i');
  const meta = document.querySelector('meta[name="csrf-token"]');
  const csrf = meta ? meta.getAttribute('content') : '';

  let inFlight = false;


  function setUI(favorited) // Change the star into filled or outline 
  {
    btn.setAttribute('data-favorited', favorited ? 1 : 0);
    btn.setAttribute('aria-pressed', favorited ? 'true' : 'false');
    if (starIcon) 
    {
      starIcon.classList.remove('fa-regular', 'fa-solid');
      starIcon.classList.add(favorited ? 'fa-solid' : 'fa-regular');
    }
  }

  btn.addEventListener('click', async (e) => {
    console.log("prrrint");
    e.preventDefault();

    // ignore if already processing
    if (inFlight) return;

    inFlight = true;
    btn.disabled = true;
    btn.style.pointerEvents = 'none';

    const currentlyFavorited = btn.getAttribute('data-favorited') === '1';
    const url = currentlyFavorited ? btn.getAttribute('data-unstar-url') : btn.getAttribute('data-star-url');

    setUI(!currentlyFavorited);

    try 
    {
      const res = await fetch(url, 
      {
        method: 'POST',
        headers: 
        {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrf,
          'Accept': 'application/json'
        },
        body: JSON.stringify({})
      });

      if (!res.ok) 
      {
        // revert UI on error
        setUI(currentlyFavorited);
        const data = await res.json().catch(()=>({}));
        alert(data.error || 'Failed to update favorite');
        return;
      }

      // success — keep UI as toggled
      setUI(!currentlyFavorited);
    } catch (err) 
    {
      setUI(currentlyFavorited);
      alert('Network error');
    } finally
    {
      inFlight = false;
      btn.disabled = false;
      btn.style.pointerEvents = '';
    }
  });
});