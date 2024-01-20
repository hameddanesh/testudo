# testudo
# https://github.com/hameddanesh/testudo
#
# Copyright 2024, Hamed Danesh
#
# Licensed under the MIT license:
# https://opensource.org/license/mit/


class Testudo:
    def form(self, value, key):
        seed = self.getSeed(key, value)
        return self.xor(self.textToBinary(value), seed)

    def unform(self, secret, seed):
        return self.binaryToText(self.xor(secret, seed))

    def textToBinary(self, text):
        a_bytes = bytes(text, "ascii")
        return " ".join(["{0:b}".format(x).rjust(7, "0") for x in a_bytes])

    def binaryToText(self, _binaryString):
        binaryString = _binaryString.replace(" ", "")
        strData = " "
        for i in range(0, len(binaryString), 7):
            tempData = binaryString[i : i + 7]
            decimalData = string = int(tempData, 2)
            strData = strData + chr(decimalData)
        return strData

    def getSeed(self, hashBinary, valueBinary):
        rep = (int(int(valueBinary.__len__()) / hashBinary.__len__())) + 1
        temp = ""

        for i in range(0, rep):
            temp += hashBinary

        hashBinary = temp

        return self.textToBinary(hashBinary)[
            0 : (self.textToBinary(valueBinary).__len__() + 1)
        ]

    def xor(self, _binaryString, _seed):
        xString = ""
        binaryString = _binaryString.replace(" ", "")
        seed = _seed.replace(" ", "")

        counter = 0
        for i in range(0, binaryString.__len__()):
            counter += 1
            if binaryString[i] != seed[i]:
                xString += "1"
            else:
                xString += "0"

            if counter >= 7:
                xString += " "
                counter = 0

        return xString
