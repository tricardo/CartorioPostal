<h1>Busca CEP - Faixas de CEP</h1>
            <form name="Geral" method="post" action="http://www.buscacep.correios.com.br/servicos/dnec/consultaFaixaCepAction.do">
              <p><span>UF :<br/>
                  <select class="f1col" name="UF">
                    <option value="AC">AC</option>
                    <option value="AL">AL</option>
                    <option value="AM">AM</option>
                    <option value="AP">AP</option>
                    <option value="BA">BA</option>
                    <option value="CE">CE</option>
                    <option value="DF">DF</option>
                    <option value="ES">ES</option>
                    <option value="GO">GO</option>
                    <option value="MA">MA</option>
                    <option value="MG">MG</option>
                    <option value="MS">MS</option>
                    <option value="MT">MT</option>
                    <option value="PA">PA</option>
                    <option value="PB">PB</option>
                    <option value="PE">PE</option>
                    <option value="PI">PI</option>
                    <option value="PR">PR</option>
                    <option value="RJ">RJ</option>
                    <option value="RN">RN</option>
                    <option value="RO">RO</option>
                    <option value="RR">RR</option>
                    <option value="RS">RS</option>
                    <option value="SC">SC</option>
                    <option value="SE">SE</option>
                    <option value="SP">SP</option>
                    <option value="TO">TO</option>
                    </select>
              </span> </p>
              <p><span>Localidade :<br/>
                <input class="t7col" type="text" maxLength="40" name="Localidade" onKeypress="if ((event.keyCode > 32 && event.keyCode < 39) || (event.keyCode > 41 && event.keyCode < 47) || (event.keyCode > 57 && event.keyCode < 65) || (event.keyCode > 90 && event.keyCode < 97)) event.returnValue = false;"/>
                </span> <span class="btnform">
                </span></p>
              <span class="btnform">
              <button type="submit" class="btn1 f2col float-right">Buscar</button>
              <input type="Hidden" name="cfm" value="1">
                <input type="hidden" name="Metodo" value="listaFaixaCEP">
                <input type="hidden" name="TipoConsulta" value="faixaCep">
                <input type="hidden" name="StartRow" value="1">
                <input type="hidden" name="EndRow" value="10">
              </span>
            </form>