def particiona(v, ini, fim):
    pivo = v[fim]
    while (ini < fim):
        while (ini < fim) and (v[ini] >= pivo):
            ini = ini + 1
        while (fim > ini) and (v[fim] < pivo):
            fim = fim - 1
        v[ini],v[fim] = v[fim],v[ini]
    return ini

def pibinhoSort(v, ini, fim):
    if (ini < fim):
        pos = particiona(v, ini, fim)
        pibinhoSort(v, ini, pos-1)
        pibinhoSort(v, pos, fim)

a = [1,2,3,4,5,6,7,8]
print(a)
pibinhoSort(a, 0, len(a)-1)
print(a)
