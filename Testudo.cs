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

using System;
using System.Linq;
using System.Text;

namespace secreturity.Testudo
{
    public class Testudo
    {
        public string form(string value, string valueHash)
        {
            string seed = getSeed(valueHash, value);
            return xor(_textToBinary(value), seed);
        }

        public string unform(string secret, string seed)
        {
            return _binaryToText(xor(secret, seed));
        }

        public string _textToBinary(string text)
        {
            Encoding encoding = Encoding.ASCII;
            return string.Join(" ", encoding.GetBytes(text).Select(byt => Convert.ToString(byt, 2).PadLeft(8, '0')));
        }

        public string _binaryToText(string _binaryString)
        {
            string result = "",
                binaryString = _binaryString.Replace(" ", "");

            byte[] bytes = new byte[binaryString.Length / 8];
            for (int i = 0; i < bytes.Length; i++)
                bytes[i] = Convert.ToByte(binaryString.Substring(i * 8, 8), 2);

            var sb = new StringBuilder();
            foreach (var b in bytes)
                sb.Append((char)b);

            result = sb.ToString();
            return result;
        }

        public string getSeed(string hashBinary, string valueBinary)
        {
            int rep = ((int)(valueBinary.Length / hashBinary.Length)) + 1;

            string temp = "";

            for (int i = 0; i < rep; i++)
                temp += hashBinary;

            hashBinary = temp;
            return _textToBinary(hashBinary).Substring(0, _textToBinary(valueBinary).Length);
        }

        public string xor(string _binaryString, string _seed)
        {
            string xString = "",
                binaryString = _binaryString.Replace(" ", ""),
                seed = _seed.Replace(" ", "");

            int counter = 0;
            for (int i = 0; i < binaryString.Length; i++)
            {
                counter++;
                if (binaryString[i] != seed[i])
                    xString += "1";
                else
                    xString += "0";

                if (counter >= 8)
                {
                    xString += " ";
                    counter = 0;
                }
            }
            return xString;
        }
    }
}