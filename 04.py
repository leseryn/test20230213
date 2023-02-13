def bsort(l:list):
    ifswap = True
    while ifswap:
        ifswap = False
        for i in range(len(l)-1):
            if(l[i]>l[i+1]):
                l[i], l[i+1] = l[i+1], l[i]
                ifswap = True
    return l



def main():
    o = [77,5,5,22,13,55,97,4,796,1,0,9]
    o = bsort(o)
    print(o)
    return o
    
if __name__ == '__main__':
    main() 