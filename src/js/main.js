($ => {
  const debounce = (callback, wait) => {
    let timeout = null;
    return (...args) => {
      const next = () => callback(...args);
      clearTimeout(timeout);
      timeout = setTimeout(next, wait);
    };
  };

  $(document).ready(() => {
    $("html").removeClass("no-js");
  });
})(jQuery);