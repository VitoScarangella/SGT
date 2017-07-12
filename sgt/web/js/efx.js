/**
 * formatCurrency
 *
 * @param number or string value: value
 * @param integer n: length of decimal
 * @param integer x: length of whole part
 * @param mixed   s: sections delimiter
 * @param mixed   c: decimal delimiter
 */
var formatCurrency = function(value, n, x, s, c) {
    value = Number(value);
    var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\D' : '$') + ')',
        num = value.toFixed(Math.max(0, ~~n));
    return (c ? num.replace('.', c) : num).replace(new RegExp(re, 'g'), '$&' + (s || ','));
};

var toggleGridViewRow = function(row, css)
{
  console.log($(row).parent().parent());
  $(row).parent().parent().find("tr").removeClass(css);
  $(row).addClass(css);
}

function disableF5(e) {
  if ((e.which || e.keyCode) == 116) e.preventDefault();
};

$("document").ready(function(){

  //$(document).bind("keydown", disableF5);

});




/*
* selector: dom selector
* mask: mask (ad esempio '0ZZZZZ,0ZZZZ')
* TODO: CURRENCY
*/
var initFieldMask = function(selector, mask)
{
  if (mask=='dateflex')
  {
    mask = 'KK/KK/KKKK'
    $(selector).mask(mask, { translation: {'K': {pattern: /[*,1]/, optional: false} } });
    return;
  }
  if (mask=='timeflex')
  {
    mask = 'KK:KK:KK'
    $(selector).mask(mask, { translation: {'K': {pattern: /[*,1]/, optional: false} } });
    return;
  }
  if (mask=='weekflex')
  {
    mask = 'KKKKKKK'
    $(selector).mask(mask, { translation: {'K': {pattern: /[*,1]/, optional: false} } });
    return;
  }

  if (mask=='decimal') {
    mask = '0ZZZZZZZZ,0Z';
    $(selector).mask(mask, { translation: {'Z': {pattern: /[0-9]/, optional: true} } });
  }

  if (mask=='number') {
    mask = '0ZZZZZZZZ';
    $(selector).mask(mask, { translation: {'Z': {pattern: /[0-9]/, optional: true} } });
  }

}
