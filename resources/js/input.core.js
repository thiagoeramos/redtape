$(document).ready(function(){
    //formatar moeda do input
	$('input.add_price').priceFormat({
		prefix: '',
		centsSeparator: '.',
		thousandsSeparator: ','
    });
	
	$(".onlynumbers").numeric();
	
	//formatar cnpj do input
	$('input.format_cnpj').mask("999.999.999/9999-99",{placeholder:" "});
	
	//formatar cnpj do input2
	$('input.format_cnpj2').mask("99.999.999/9999-99",{placeholder:" "});
	
	//formatar cnpj do input apenas numeros
	$('input.format_cnpj3').mask("99999999999999",{placeholder:" "});
	
	//formatar cpf do input
	$('input.format_cpf').mask("999.999.999-99",{placeholder:" "});
	
	//formatar cpf do input sem pontuacao
	$('input.format_cpf2').mask("99999999999",{placeholder:" "});
	
	// formatar Agencia / Conta bancária no input
	$('input.format_rg').mask("999999999",{placeholder:"0"});
	
	//formatar telefone do input
	$('input.format_tel').mask("(99) 9999-9999",{placeholder:" "});
	
	//formatar datetime br do input
	$('input.format_datetime').mask("99/99/9999 99:99",{placeholder:" "});
	
	$('input.format_date').mask("99/99/9999",{placeholder:" "});
	
	$('input.format_date_new').mask("99/99/9999",{placeholder:" "});
	
	//formatar porcentagem
	$('input.format_percent2').mask("999,99",{placeholder:"0"});
	
	//formatar porcentagem
	$('input.format_percent3').mask("999,999",{placeholder:"0"});
	
	//formatar porcentagem
	$('input.format_percent4').mask("99",{placeholder:"0"});
	
	//formatar cep do input
	$('input.format_cep').mask("99999-999",{placeholder:" "});
	
	// formatar hora no input
	$('input.format_hora').mask("99:99",{placeholder:" "});
	
	// formatar Agencia / Conta bancária no input
	$('input.format_banco').mask("99999-99",{placeholder:"0"});
	
	// formatacao metragem de gondolas e mix
	$('input.geral').mask("99.99",{placeholder:"0"});
});