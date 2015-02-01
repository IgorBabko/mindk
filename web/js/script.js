function deleteComment(obj) {
    var commentId = $(obj).prev().text();
    var amountOfComments = $('#amountOfComments span');
    $.ajax({
        type: "POST",
        url: "/comments/" + commentId + "/delete",
        success: function () {
            var commentDiv = $(obj).parent().parent();
            commentDiv.prev().remove();
            commentDiv.remove();
            amountOfComments.text(parseInt(amountOfComments.text()) - 1);
        }
    });
}

$(document).ready(function () {


    var editor = $('#editor');
    var commentButton = $('#commentButton');

    /* Adding and deleting comments */

    editor.wysiwyg();
    editor.bind('input propertychange', function () {
        var length = $(this).text().length - 13;
        if (length == 0) {
            commentButton.prop('disabled', true);
        } else {
            commentButton.removeAttr('disabled');
        }
    });

    commentButton.click(function () {

        var text = editor.html();
        var postTitle = $('#commentPost').val();
        var amountOfComments = $('#amountOfComments span');
        $.ajax({
            type: "POST",
            url: "/comment/add",
            data: 'postTitle=' + postTitle + '&text=' + text,
            success: function (html) {
                editor.val('');
                commentButton.parent().parent().next().after(html);
                amountOfComments.text(parseInt(amountOfComments.text()) + 1);
            }
        });
    });

    /* Scroll to the top */

    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.scrollToTop').fadeIn();
        } else {
            $('.scrollToTop').fadeOut();
        }
    });

    $('.scrollToTop').click(function () {
        $('html, body').animate({scrollTop: 0}, 200);
        return false;
    });

    /* CodeMirror */

    function makeEditor(textarea) {
        return CodeMirror.fromTextArea(textarea, {
            lineNumbers: true,
            matchBrackets: true,
            mode: "application/x-httpd-php",
            indentUnit: 4,
            indentWithTabs: true,
            theme: 'twilight',
            readOnly: true
        });
    }

    var codeEditors = document.getElementsByClassName('codeEditor');
    var size = codeEditors.length;
    var codeEditor = null;
    for (var i = 0; i < size; ++i) {
        codeEditor = makeEditor(codeEditors[i]);
    }
});