def gcd(a, b):
    if (a == 0):
        return b
    return gcd(b%a, a)

def print_divisors_list(divisors):
    for i in range(len(divisors)):
        print(divisors[i], end=" ")
    print()

def main():
    # my code here
    import os
    x = 144
    y = 176
    _gcd_ = gcd(x, y)

    divisors = []

    for i in range(1, _gcd_+1):
        if _gcd_ % i == 0:
            divisors.append(i)
#   test
#   print_divisors_list(divisors)

    for divisor in divisors:
        Command = "./phods4 " + str(divisor)
        os.system(Command)


if __name__ == "__main__":
    main()
