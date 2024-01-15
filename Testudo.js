/*
 * testudo
 * https://github.com/hameddanesh/testudo
 *
 * Copyright 2024, Hamed Danesh
 *
 * Licensed under the MIT license:
 * https://opensource.org/license/mit/
 *
 */

let testudo = function () {
    if (this.__proto__.constructor !== testudo) {
        return new testudo();
    }

    this.form = function (value, valueHash) {
        let seed = this.getSeed(valueHash, value)
        return this.xor(this.textToBinary(value), seed)
    }

    this.unform = function (secret, seed) {
        return this.binaryToText(this.xor(secret, seed))
    }

    this.textToBinary = function (text) {
        let length = text.length,
            output = [];

        for (let i = 0; i < length; i++) {
            let binary = text[i].charCodeAt().toString(2);
            output.push(Array(8 - binary.length + 1).join("0") + binary);
        }
        return output.join("");
    }

    this.binaryToText = function (binaryString) {
        let _binaryString = "",
            counter = 0

        for (let i = 0; i < binaryString.length; i++) {
            counter++
            _binaryString += binaryString[i]
            if (counter >= 8) {
                _binaryString += " "
                counter = 0
            }
        }

        _binaryString = _binaryString.substring(0, (_binaryString.length - 1))

        return _binaryString.split(" ").map(letter => String.fromCharCode(parseInt(letter, 2))).join('')
    }

    this.getSeed = function (hashBinary, valueBinary) {
        let rep = parseInt(valueBinary.length / hashBinary.length) + 1,
            temp = ''

        for (let i = 0; i < rep; i++)
            temp += hashBinary

        hashBinary = temp

        return this.textToBinary(hashBinary).substring(0, this.textToBinary(valueBinary).length)
    }

    this.xor = function (binaryString, seed) {
        let xString = '',
            counter = 0
            
        for (let i = 0; i < binaryString.length; i++) {
            counter++
            if (binaryString[i] != seed[i])
                xString += '1'
            else
                xString += '0'

            if (counter >= 8) {
                xString += ""
                counter = 0
            }
        }
        return xString
    }
}
