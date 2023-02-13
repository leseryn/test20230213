import argparse
def twoSum(n:list, t:int):

    for i in range(len(n)):
        for j in range(i+1, len(n)):
            # print(n[i]+n[j])
            if n[i]+n[j]==t:
                return [i,j]


def main():
    parser = argparse.ArgumentParser()
    parser.add_argument("-t","--target",type=int, help="target", default=9)
    parser.add_argument("-n","--nums",type=str, help="nums", default="2,7,11,15")
    args = parser.parse_args()
    

    try:
        nums = args.nums.split(',')
        for i in range(len(nums)):
            nums[i] = int(nums[i])
    except:
        print('nums in wrong format.')

    target = args.target
    print('target: ',target,', nums: ', nums)

    res = twoSum(nums, target)
    print('result: ', res)
    return res
    
if __name__ == '__main__':
    main() 