def main():
    l = [0,1,2,3,4,5,6,7,8,9]
    oddlist = []
    evenlist = []

    for i in l:
        if i&1:
            oddlist.append(i) 
        else:
            evenlist.append(i)
    print(oddlist, evenlist)
    return oddlist, evenlist
if __name__ == '__main__':
    main() 