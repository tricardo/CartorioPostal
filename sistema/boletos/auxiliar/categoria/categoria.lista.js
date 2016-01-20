/**
 * @author caio
 */
$(document).ready(function(){
    $("#lista .excluir").click(function(){
       if (confirm('Realmente deseja exluir esse registro?')) {
			$("#content").load(this.href, {ajax: 1}, function(){});
		}
		return false;
    });
});
