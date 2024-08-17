def print_list(myList):
    for name in globals():
        if eval(name) == myList:
            print(name + ": ")
    print(*myList, end="\n\n")

def main():
    import os
    x = 144
    y = 176
    divisors_144, divisors_176, pairs, block_sizes = [], [], [], []
    block_sizes_fixed = []

    for i in range(1, 145):
        if 144 % i == 0:
            divisors_144.append(i)
        if 176 % i == 0:
            divisors_176.append(i)

    for i in range(145, 177):
        if 176 % i == 0:
            divisors_176.append(i)

    # make list of pairs
    for divisor1 in divisors_144:
        for divisor2 in divisors_176:
            pairs.append((divisor1, divisor2))
    
    # testing
    '''
    print_list(divisors_144)
    print_list(divisors_176)
    
    print("144 has " + str(len(divisors_144)) + " divisors")
    print("176 has " + str(len(divisors_176)) + " divisors")

    print_list(pairs)
    print("There are " + str(len(pairs)) + " different combinations")
    '''
    for pair in pairs:
        block_sizes.append(pair[0] * pair[1])
    block_sizes.sort()

    temp = None
    for size in block_sizes:
        if temp != size:
            block_sizes_fixed.append(size)
            temp = size
    
#    print_list(block_sizes)
#    print_list(block_sizes_fixed)

    for size in block_sizes_fixed:
        Command = "./phods4 " + str(size)
        os.system(Command)

if __name__ == "__main__":
    main()


