$(function(){
    let href = location.href.split('/');
    if (href[href.length-2].toLowerCase() === 'editar') {
        $("span[id^=add-btn]").map((i, x) => {$(x).remove();});
    }

    if (href[href.length-1].toLowerCase() === 'adicionar') {
        let count_email = $("div[id^=email").length+1;
        let count_tel = $("div[id^=tel").length+1;
        let count_end = $("div[id^=end").length+1;

        $("#add-btn-email").click(()=>{
            add_email();
        });

        let add_email = () => {
            let clone = $("#email-"+(count_email-1))[0].cloneNode(true);
            clone.innerHTML = clone.innerHTML.replaceAll('EMAIL-'+(count_email-1), 'EMAIL-'+count_email);
            clone.children[0].innerText = 'E-MAIL '+count_email+':';
            clone.id = 'email-'+count_email;
            
            $("#add-btn-email").remove();
            $("#email-"+(count_email-1))[0].insertAdjacentElement('afterend', clone);

            $("#add-btn-email").click(()=>{
                add_email();
            });
            
            count_email++;
        }

        $("#add-btn-tel").click(()=>{
            add_tel();
        });

        let add_tel = () => {
            let clone = $("#tel-"+(count_tel-1))[0].cloneNode(true);
            clone.innerHTML = clone.innerHTML.replaceAll('TELEFONE-'+(count_tel-1), 'TELEFONE-'+count_tel);
            clone.children[0].innerText = 'TELEFONE '+count_tel+':';
            clone.id = 'tel-'+count_tel;

            $("#add-btn-tel").remove();
            $("#tel-"+(count_tel-1))[0].insertAdjacentElement('afterend', clone);

            $("#add-btn-tel").click(()=>{
                add_tel();
            });
            
            count_tel++;
        }

        $("#add-btn-end").click(()=>{
            add_end();
        });

        let add_end = () => {
            let clone = $("#end-"+(count_end-1))[0].cloneNode(true);

            clone.innerHTML = clone.innerHTML.replaceAll('RUA-'+(count_end-1), 'RUA-'+count_end);
            clone.innerHTML = clone.innerHTML.replaceAll('BAIRRO-'+(count_end-1), 'BAIRRO-'+count_end);
            clone.innerHTML = clone.innerHTML.replaceAll('NUMERO-'+(count_end-1), 'NUMERO-'+count_end);
            clone.innerHTML = clone.innerHTML.replaceAll('CIDADE-'+(count_end-1), 'CIDADE-'+count_end);
            clone.innerHTML = clone.innerHTML.replaceAll('CEP-'+(count_end-1), 'CEP-'+count_end);
            clone.children[0].innerText = 'ENDEREÇO '+count_end;
            clone.id = 'end-'+count_end;

            $("#add-btn-end").remove();
            $("#end-"+(count_end-1))[0].insertAdjacentElement('afterend', clone);

            $("#add-btn-end").click(()=>{
                add_end();
            });
            
            count_end++;
        }
    }

    $("input").map((i,x)=>{
        x.setAttribute('autocomplete', 'off');
    });
});