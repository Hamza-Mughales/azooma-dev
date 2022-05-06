    $("#restMainForm").validate({});
    $('.chzn-select').chosen().change(function () {
    var selected = [];

    $(this).parent().parent().find("option")
      .each(function () {
        if (this.selected) {
          selected[this.value] = this;
        }
      })
      .each(function () {
        this.disabled = selected[this.value] && selected[this.value] !== this;
      })
      .each(function () {
        if ($(this).parent().data('maxpersons') === $(this).parent().find('option:selected').length) {
          $(this).parent().find('option:not(:selected)').prop('disabled', true);
        }
      });
    $('.chzn-select').trigger("liszt:updated");
  });
$(document).ready(function(){
    var selected = [];
    var chosen='.chzn-select';
    $(chosen).parent().parent().find("option")
      .each(function () {
        if (chosen.selected) {
          selected[chosen.value] = this;
        }
      })
      .each(function () {
        this.disabled = selected[this.value] && selected[this.value] !== chosen;
      })
      .each(function () {
        if ($(this).parent().data('maxpersons') === $(this).parent().find('option:selected').length) {
          $(this).parent().find('option:not(:selected)').prop('disabled', true);
        }
      });
    $('.chzn-select').trigger("liszt:updated");
})



function addmore() {
  var element = '<div id="input-' + counter + '" class="input-' + counter + '" ><input type="text" name="rest_Email[]"  placeholder="Restaurant Email, Managers Email, Owner`s Email"  /><a class="close sufrati-close" href="javascript:void(0);" data-dismiss="input-' + counter + '">&times;</a></div>';
  $("#memberemails").append(element);
  counter++;
}

function addmoreAr() {
  var element = '<div id="input-' + counter + '"><a class="close sufrati-close" href="javascript:void(0);" data-dismiss="input-' + counter + '">&times;</a><input type="text" name="rest_Email[]"  placeholder="البريد الإلكتروني"   /></div>';
  $("#memberemails").append(element);
  counter++;
}

$(document).on("click", ".sufrati-close", function(event) {   
    var dismiss = $(this).attr('data-dismiss');
    $(this).parent().remove();
});