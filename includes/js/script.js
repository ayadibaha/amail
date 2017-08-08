$(document).ready( function() {
  $('#ClickWordList li').click(function() { 
    $("#txtMessage").insertAtCaret($(this).text());
    return false
  });
  $("#file").on("change",function(input){
    var filename = $("#file").val().split('\\').pop();
    $("#filename").html(filename);
    $("#uploadCSV").submit();
  });
  $('#leadList').DataTable({
    "searching":false,
    "paging":true,
    "lengthChange":false
  });
});

$.fn.insertAtCaret = function (myValue) {
  return this.each(function(){
  //IE support
  if (document.selection) {
    this.focus();
    sel = document.selection.createRange();
    sel.text = myValue;
    this.focus();
  }
  //MOZILLA / NETSCAPE support
  else if (this.selectionStart || this.selectionStart == '0') {
    var startPos = this.selectionStart;
    var endPos = this.selectionEnd;
    var scrollTop = this.scrollTop;
    this.value = this.value.substring(0, startPos)+ myValue+ this.value.substring(endPos,this.value.length);
    this.focus();
    this.selectionStart = startPos + myValue.length;
    this.selectionEnd = startPos + myValue.length;
    this.scrollTop = scrollTop;
  } else {
    this.value += myValue;
    this.focus();
  }
  });
};