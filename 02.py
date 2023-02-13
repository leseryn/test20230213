def main():
    s = "人易科技:上 機 測 驗 - 演算法"
    s = s.replace(":","：")
    print(s[:s.find('-')])

if __name__ == '__main__':
    main() 