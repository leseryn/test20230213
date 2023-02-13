def bsort(l:list):
    ifswap = True
    while ifswap:
        ifswap = False
        for i in range(len(l)-1):
            if(l[i]>l[i+1]):
                l[i], l[i+1] = l[i+1], l[i]
                ifswap = True
    return l

def f(la:list, lb:list):
    la = bsort(la)
    lb = bsort(lb)

    diff = []
    union = []
    inter = []
    i = j = 0

    while i<len(la) and j<len(lb):
        if la[i]==lb[j]:
            union.append(la[i])
            inter.append(la[i])
            i += 1
            j += 1
            
        elif la[i]>lb[j]:
            union.append(lb[j])
            j += 1
        else:
            diff.append(la[i])
            union.append(la[i])
            i += 1

    union+= la[i:]+lb[j:]
    diff += la[i:] 

    return inter, diff ,union



def main():
    a = [77,5,5,22,13,55,97,4,796,1,0,9]
    b = [0,1,2,3,4,5,6,7,8,9]
    c,d,e = f(a,b)
    print('c:', c,'\nd:',d,'\ne:',e)

    return c,d,e


    
if __name__ == '__main__':
    main() 