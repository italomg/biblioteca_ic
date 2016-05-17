import pickle

class Aluno:
    def __init__(self):
        self.nome=""
        self.notas=[]
    def printAluno(self):
        print("Nome: ", self.nome)
        print("Notas: ", self.notas)
    def incluiNota(self, nota):
        self.notas.append(nota)
    def alteraNota(self, nota, nova):
        if (nota-1) in range(len(self.notas)):
            self.notas[nota-1] = nova
        else:
            print("Numero de nota invalido, cara palida!")

class Cadastro:
    def __init__(self):
        self.cadastro=[]
    def incluiAluno(self,a):
        quevedo = False
        for i in self.cadastro:
            if (i.nome == a.nome):
                print("Aluno ja existe, cara palida!")
                quevedo = True
        if (quevedo == False):
            self.cadastro.append(a)
    def excluiAluno(self, nome):
        for i in self.cadastro:
            if i.nome==nome:
                self.cadastro.remove(i)
    def printCad(self):
        print("Imprimindo Cadastro")
        for a in self.cadastro:
            a.printAluno()

def menuPrincipal(cadastro):
    while True:
        print("\n\nEscolha uma opc~ao\n1-Incluir Aluno\n2-Excluir Aluno\n3-Incluir Nota\n4-Alterar Aluno\n5-Alterar Nota\n6-Listar Turma\n7-Sair")
        op = input()
        if(op=="1"):
            a = Aluno()
            a.nome = input("Digite nome do aluno:")
            cadastro.incluiAluno(a)
        elif(op=="2"):
            nome = input("Digite nome do aluno:")
            cadastro.excluiAluno(nome)
        elif(op=="3"):
            nome = input("Digite nome do aluno:")
            nota = float(input("Digite a nota:"))
            for a in cadastro.cadastro:
                if(a.nome == nome):
                    a.incluiNota(nota)
                    break
        elif(op=="4"):
            nome = input("Digite nome do aluno:")
            for a in cadastro.cadastro:
                if (a.nome == nome):
                    novo = input("Digite novo nome do aluno:")
                    a.nome = novo
                    break
        elif(op=="5"):
            nome = input("Digite nome do aluno:")
            for a in cadastro.cadastro:
                if (a.nome == nome):
                    nota = int(input("Digite o numero da nota:"))
                    nova = float(input("Digite a nova nota:"))
                    a.alteraNota(nota, nova)
                    break
        elif(op=="6"):
            cadastro.printCad()
        elif(op=="7"):
            return
        else:
            print("Opcao invalida")

try:
    arq = open("cadastro.bin", "r+b")
    cadastro = pickle.load(arq)
    menuPrincipal(cadastro)
    print("salvando cadastro")
    arq.seek(0,0)
    pickle.dump(cadastro, arq)
    arq.close()
except IOError:
    arq = open("cadastro.bin", "wb") #cria arquivo se n~ao existir
    cadastro = Cadastro()
    menuPrincipal(cadastro)
    pickle.dump(cadastro, arq)
    arq.close()
except:
    print("Algo esta errado!")
