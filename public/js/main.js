// Funções gerais do sistema

// Formatar moeda
function formatarMoeda(valor) {
    return new Intl.NumberFormat('pt-BR', {
        style: 'currency',
        currency: 'BRL'
    }).format(valor);
}

// Formatar data
function formatarData(data) {
    return new Date(data).toLocaleDateString('pt-BR');
}

// Validar email
function validarEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}

// Validar CNPJ
function validarCNPJ(cnpj) {
    cnpj = cnpj.replace(/[^\d]/g, '');
    if (cnpj.length !== 14) return false;
    
    let tamanho = cnpj.length - 2;
    let numeros = cnpj.substring(0, tamanho);
    let digitos = cnpj.substring(tamanho);
    let soma = 0;
    let pos = 0;
    
    for (let i = tamanho - 1; i >= 0; i--) {
        soma += numeros.charAt(tamanho - 1 - i) * (pos + 2);
        pos++;
    }
    
    let resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado !== parseInt(digitos.charAt(0))) return false;
    
    tamanho = tamanho - 1;
    numeros = cnpj.substring(0, tamanho);
    soma = 0;
    pos = 0;
    
    for (let i = tamanho - 1; i >= 0; i--) {
        soma += numeros.charAt(tamanho - 1 - i) * (pos + 2);
        pos++;
    }
    
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado !== parseInt(digitos.charAt(1))) return false;
    
    return true;
}

// Máscara para CNPJ
function mascaraCNPJ(cnpj) {
    cnpj = cnpj.replace(/\D/g, "");
    if (cnpj.length > 14) cnpj = cnpj.substring(0, 14);
    cnpj = cnpj.replace(/^(\d{2})(\d)/, "$1.$2");
    cnpj = cnpj.replace(/^(\d{2})\.(\d{3})(\d)/, "$1.$2.$3");
    cnpj = cnpj.replace(/\.(\d{3})(\d)/, ".$1/$2");
    cnpj = cnpj.replace(/(\d{4})(\d)/, "$1-$2");
    return cnpj;
}

// Máscara para Telefone
function mascaraTelefone(telefone) {
    telefone = telefone.replace(/\D/g, '');
    telefone = telefone.replace(/(\d{2})(\d)/, '($1) $2');
    telefone = telefone.replace(/(\d{5})(\d)/, '$1-$2');
    return telefone;
}

// Fechar alerta
function fecharAlerta(elemento) {
    elemento.parentElement.style.display = 'none';
}

// Mostrar notificação
function mostrarNotificacao(mensagem, tipo = 'info') {
    const div = document.createElement('div');
    div.className = `alert alert-${tipo}`;
    div.innerHTML = `
        ${tipo === 'success' ? '✅' : tipo === 'error' ? '❌' : 'ℹ️'} 
        ${mensagem}
        <span class="close-alert" onclick="fecharAlerta(this.parentElement)">×</span>
    `;
    document.body.insertBefore(div, document.body.firstChild);
    
    setTimeout(() => {
        div.style.display = 'none';
    }, 5000);
}

// Calcular dias entre datas
function calcularDias(dataInicio, dataFim) {
    const inicio = new Date(dataInicio);
    const fim = new Date(dataFim);
    const diferenca = fim.getTime() - inicio.getTime();
    return Math.ceil(diferenca / (1000 * 60 * 60 * 24)) + 1;
}

// Verificar se é data válida
function ehDataValida(data) {
    return data instanceof Date && !isNaN(data);
}

// Scroll para elemento
function scrollParaElemento(elemento) {
    if (elemento) {
        elemento.scrollIntoView({ behavior: 'smooth' });
    }
}

// Modal simples
function abrirModal(idModal) {
    const modal = document.getElementById(idModal);
    if (modal) {
        modal.classList.add('active');
    }
}

function fecharModal(idModal) {
    const modal = document.getElementById(idModal);
    if (modal) {
        modal.classList.remove('active');
    }
}

// Alterna entre abas do modal de autenticação (login / registro / admin)
function switchAuthTab(tab) {
    const loginPanel = document.getElementById('authLogin');
    const regPanel = document.getElementById('authRegister');
    const adminPanel = document.getElementById('authAdmin');
    const title = document.getElementById('authModalTitle');
    const tabLoginBtn = document.getElementById('tabLogin');
    const tabRegisterBtn = document.getElementById('tabRegister');
    const tabAdminBtn = document.getElementById('tabAdmin');

    if (!loginPanel || !regPanel || !title) return;

    // Reset all
    if (loginPanel) loginPanel.style.display = 'none';
    if (regPanel) regPanel.style.display = 'none';
    if (adminPanel) adminPanel.style.display = 'none';
    if (tabLoginBtn) { tabLoginBtn.classList.remove('btn-primary'); tabLoginBtn.classList.add('btn-secondary'); }
    if (tabRegisterBtn) { tabRegisterBtn.classList.remove('btn-primary'); tabRegisterBtn.classList.add('btn-secondary'); }
    if (tabAdminBtn) { tabAdminBtn.classList.remove('btn-primary'); tabAdminBtn.classList.add('btn-secondary'); }

    // Show selected
    if (tab === 'register') {
        regPanel.style.display = 'block';
        title.textContent = 'Cadastro';
        if (tabRegisterBtn) { tabRegisterBtn.classList.remove('btn-secondary'); tabRegisterBtn.classList.add('btn-primary'); }
    } else if (tab === 'admin') {
        adminPanel.style.display = 'block';
        title.textContent = 'Administrador';
        if (tabAdminBtn) { tabAdminBtn.classList.remove('btn-secondary'); tabAdminBtn.classList.add('btn-primary'); }
    } else {
        loginPanel.style.display = 'block';
        title.textContent = 'Entrar';
        if (tabLoginBtn) { tabLoginBtn.classList.remove('btn-secondary'); tabLoginBtn.classList.add('btn-primary'); }
    }
}

// Confirmação
function confirmar(mensagem) {
    return confirm(mensagem);
}

// Exportar para CSV
function exportarCSV(dados, nome = 'dados') {
    const csv = [];
    
    // Headers
    const headers = Object.keys(dados[0] || {});
    csv.push(headers.join(','));
    
    // Dados
    dados.forEach(linha => {
        const valores = headers.map(header => {
            const valor = linha[header];
            return typeof valor === 'string' && valor.includes(',') 
                ? `"${valor}"` 
                : valor;
        });
        csv.push(valores.join(','));
    });
    
    // Criar download
    const blob = new Blob([csv.join('\n')], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    const url = URL.createObjectURL(blob);
    
    link.setAttribute('href', url);
    link.setAttribute('download', `${nome}.csv`);
    link.style.visibility = 'hidden';
    
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

// Imprimir elemento
function imprimirElemento(idElemento) {
    const elemento = document.getElementById(idElemento);
    if (elemento) {
        const janela = window.open('', '', 'height=400,width=600');
        janela.document.write(elemento.innerHTML);
        janela.document.close();
        janela.print();
    }
}

// Debounce function
function debounce(funcao, delay = 500) {
    let timeoutId;
    return function(...args) {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => funcao(...args), delay);
    };
}

// Busca em tempo real
function buscarDados(inputId, containerResultadosId, funcaoBusca) {
    const input = document.getElementById(inputId);
    const container = document.getElementById(containerResultadosId);
    
    if (!input || !container) return;
    
    const buscar = debounce(async (termo) => {
        if (termo.length < 2) {
            container.innerHTML = '';
            return;
        }
        
        const resultados = await funcaoBusca(termo);
        container.innerHTML = resultados;
    });
    
    input.addEventListener('input', (e) => {
        buscar(e.target.value);
    });
}

// LocalStorage wrapper
const storage = {
    definir: (chave, valor) => {
        localStorage.setItem(chave, JSON.stringify(valor));
    },
    obter: (chave) => {
        const item = localStorage.getItem(chave);
        return item ? JSON.parse(item) : null;
    },
    remover: (chave) => {
        localStorage.removeItem(chave);
    },
    limpar: () => {
        localStorage.clear();
    }
};

// Temas (claro/escuro)
const temas = {
    ativar: (temaNome) => {
        document.documentElement.setAttribute('data-tema', temaNome);
        storage.definir('tema', temaNome);
    },
    obterTema: () => {
        return storage.obter('tema') || 'claro';
    }
};

// Inicializar ao carregar página
document.addEventListener('DOMContentLoaded', function() {
    // Aplicar tema salvo
    const temaSalvo = temas.obterTema();
    if (temaSalvo !== 'claro') {
        temas.ativar(temaSalvo);
    }
    
    // Adicionar máscaras a inputs
    document.querySelectorAll('input[data-mask="cnpj"]').forEach(input => {
        input.addEventListener('input', (e) => {
            e.target.value = mascaraCNPJ(e.target.value);
        });
    });
    
    document.querySelectorAll('input[data-mask="telefone"]').forEach(input => {
        input.addEventListener('input', (e) => {
            e.target.value = mascaraTelefone(e.target.value);
        });
    });
});

// Fechar modais ao clicar fora
document.addEventListener('click', function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.classList.remove('active');
    }
});

// Prevenir envio duplo de formulários
document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function(e) {
        const botao = this.querySelector('button[type="submit"]');
        if (botao) {
            botao.disabled = true;
            botao.style.opacity = '0.6';
        }
    });
});
